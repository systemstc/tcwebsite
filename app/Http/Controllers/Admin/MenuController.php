<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\ActivityLog;

class MenuController extends Controller
{
    public function index()
    {
        $topMenus = MenuItem::with(['allChildren.page', 'page'])
            ->whereNull('parent_id')
            ->orderBy('sort_order', 'asc')
            ->get();

        $allPages = Page::orderBy('title_en', 'asc')->get();
        $parentOptions = $this->buildHierarchicalOptions($topMenus);
        $allMenuItems = MenuItem::with('page')->orderBy('sort_order', 'asc')->get();

        return view('admin.menus.index', compact('topMenus', 'allPages', 'parentOptions', 'allMenuItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_hi' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:500',
            'target' => 'nullable|in:_self,_blank',
            'sort_order' => 'nullable|integer',
        ]);

        $item = MenuItem::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'title_en' => $validated['title_en'],
            'title_hi' => $validated['title_hi'] ?? null,
            'type' => $validated['type'],
            'page_id' => ($validated['type'] === 'page') ? ($validated['page_id'] ?? null) : null,
            'url' => ($validated['type'] === 'custom') ? ($validated['url'] ?? '#') : null,
            'target' => $validated['target'] ?? '_self',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'menu_items', $item->id, "Created Menu Item: {$item->title_en}");

        return redirect()->route('admin.menus.index')->with('success', "Menu item '{$item->title_en}' created successfully.");
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_hi' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:500',
            'target' => 'nullable|in:_self,_blank',
            'sort_order' => 'nullable|integer',
        ]);

        // Prevent setting itself or any descendant as parent (prevents circular loop)
        $parentId = $validated['parent_id'] ?? null;
        if ($parentId) {
            if ((int)$parentId === (int)$menu->id) {
                return back()->with('error', 'Cannot set a menu item as its own parent.');
            }
            $descendants = $this->getDescendantIds($menu);
            if (in_array((int)$parentId, $descendants)) {
                return back()->with('error', 'Cannot set a nested child item as the parent.');
            }
        }

        $menu->update([
            'parent_id' => $parentId,
            'title_en' => $validated['title_en'],
            'title_hi' => $validated['title_hi'] ?? null,
            'type' => $validated['type'],
            'page_id' => ($validated['type'] === 'page') ? ($validated['page_id'] ?? null) : null,
            'url' => ($validated['type'] === 'custom') ? ($validated['url'] ?? '#') : null,
            'target' => $validated['target'] ?? '_self',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'menu_items', $menu->id, "Updated Menu Item: {$menu->title_en}");

        return redirect()->route('admin.menus.index')->with('success', "Menu item '{$menu->title_en}' updated successfully.");
    }

    public function destroy(MenuItem $menu)
    {
        $title = $menu->title_en;
        $id = $menu->id;
        $menu->delete();

        ActivityLog::record('delete', 'menu_items', $id, "Deleted Menu Item: {$title}");

        return redirect()->route('admin.menus.index')->with('success', "Menu item '{$title}' removed successfully.");
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items', []);

        if (empty($items) && $request->has('tree')) {
            $items = $this->flattenTreeInput($request->input('tree'));
        }

        if (!empty($items)) {
            \DB::transaction(function () use ($items) {
                foreach ($items as $entry) {
                    $id = $entry['id'] ?? null;
                    if (!$id) continue;
                    $parentId = !empty($entry['parent_id']) ? (int)$entry['parent_id'] : null;
                    $sortOrder = isset($entry['sort_order']) ? (int)$entry['sort_order'] : 0;

                    MenuItem::where('id', $id)->update([
                        'parent_id' => $parentId,
                        'sort_order' => $sortOrder,
                    ]);
                }
            });

            ActivityLog::record('update', 'menu_items', 0, "Updated Header Menu Hierarchy via Drag & Drop");
            return response()->json(['status' => 'success', 'message' => 'Menu hierarchy updated successfully!']);
        }

        // Legacy fallback
        if ($request->has('order')) {
            foreach ($request->input('order') as $index => $id) {
                MenuItem::where('id', $id)->update(['sort_order' => $index + 1]);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'No items received'], 400);
    }

    private function buildHierarchicalOptions($items, $depth = 0)
    {
        $result = [];
        foreach ($items as $item) {
            $prefix = $depth === 0 ? '' : str_repeat('— ', $depth) . '↳ ';
            $levelBadge = $depth === 0 ? ' [Top Tab]' : ' [Level ' . ($depth + 1) . ']';
            $result[] = (object)[
                'id' => $item->id,
                'title' => $prefix . $item->title_en . ($item->title_hi ? " ({$item->title_hi})" : '') . $levelBadge,
                'depth' => $depth,
            ];

            if ($item->allChildren && $item->allChildren->count()) {
                $result = array_merge($result, $this->buildHierarchicalOptions($item->allChildren, $depth + 1));
            }
        }
        return $result;
    }

    private function getDescendantIds(MenuItem $item)
    {
        $ids = [];
        $children = MenuItem::where('parent_id', $item->id)->get();
        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }
        return $ids;
    }

    private function flattenTreeInput(array $tree, $parentId = null, &$orderCounter = 1)
    {
        $flat = [];
        foreach ($tree as $node) {
            $id = $node['id'] ?? null;
            if (!$id) continue;
            $flat[] = [
                'id' => $id,
                'parent_id' => $parentId,
                'sort_order' => $orderCounter++,
            ];
            if (!empty($node['children']) && is_array($node['children'])) {
                $flat = array_merge($flat, $this->flattenTreeInput($node['children'], $id, $orderCounter));
            }
        }
        return $flat;
    }
}
