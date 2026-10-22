<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndustryTechIssue;
use App\Models\IndustryTechIssueReply;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IndustryTechIssueAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = IndustryTechIssue::withCount(['replies', 'votes']);

        if ($search = trim($request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('industry_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($urgency = $request->input('urgency')) {
            $query->where('urgency', $urgency);
        }

        $issues = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $stats = [
            'total' => IndustryTechIssue::count(),
            'open' => IndustryTechIssue::where('status', 'open')->count(),
            'in_progress' => IndustryTechIssue::where('status', 'in_progress')->count(),
            'solved' => IndustryTechIssue::where('status', 'solved')->count(),
        ];

        return view('admin.industry-tech-issues.index', compact('issues', 'stats'));
    }

    public function create()
    {
        return view('admin.industry-tech-issues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'industry_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'category' => 'required|string',
            'urgency' => 'required|string|in:Low,Medium,High,Critical',
            'tags' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|string|in:open,in_progress,solved,closed',
            'solution' => 'nullable|string',
            'solution_by' => 'nullable|string|max:255',
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (IndustryTechIssue::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $issue = IndustryTechIssue::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'industry_name' => $validated['industry_name'],
            'contact_person' => $validated['contact_person'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
            'tags' => $validated['tags'] ?? null,
            'description' => $validated['description'],
            'status' => $validated['status'] ?? 'open',
            'solution' => $validated['solution'] ?? null,
            'solution_by' => $validated['solution_by'] ?? null,
            'solution_provided_at' => !empty($validated['solution']) ? now() : null,
            'is_active' => true,
        ]);

        ActivityLog::record('issue_created', 'industry_tech_issues', $issue->id, 'Created issue: ' . $issue->title);

        return redirect()->route('admin.industry-tech-issues.index')->with('success', 'Technical issue created successfully.');
    }

    public function show($id)
    {
        $issue = IndustryTechIssue::with(['replies' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.industry-tech-issues.show', compact('issue'));
    }

    public function edit($id)
    {
        $issue = IndustryTechIssue::findOrFail($id);
        return view('admin.industry-tech-issues.edit', compact('issue'));
    }

    public function update(Request $request, $id)
    {
        $issue = IndustryTechIssue::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'industry_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'category' => 'required|string',
            'urgency' => 'required|string|in:Low,Medium,High,Critical',
            'tags' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:open,in_progress,solved,closed',
            'solution' => 'nullable|string',
            'solution_by' => 'nullable|string|max:255',
        ]);

        $issue->update([
            'title' => $validated['title'],
            'industry_name' => $validated['industry_name'],
            'contact_person' => $validated['contact_person'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
            'tags' => $validated['tags'] ?? null,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'solution' => $validated['solution'] ?? null,
            'solution_by' => $validated['solution_by'] ?? null,
            'solution_provided_at' => (!empty($validated['solution']) && !$issue->solution_provided_at) ? now() : $issue->solution_provided_at,
        ]);

        ActivityLog::record('issue_updated', 'industry_tech_issues', $issue->id, 'Updated issue details: ' . $issue->title);

        return redirect()->route('admin.industry-tech-issues.show', $issue->id)->with('success', 'Technical issue updated successfully.');
    }

    public function updateSolution(Request $request, $id)
    {
        $issue = IndustryTechIssue::findOrFail($id);

        $validated = $request->validate([
            'solution' => 'required|string',
            'solution_by' => 'nullable|string|max:255',
            'status' => 'required|string|in:open,in_progress,solved,closed',
        ]);

        $issue->update([
            'solution' => $validated['solution'],
            'solution_by' => $validated['solution_by'] ?: 'Textiles Committee Technical Expert Cell',
            'solution_provided_at' => now(),
            'status' => $validated['status'],
        ]);

        ActivityLog::record(
            'solution_provided',
            'industry_tech_issues',
            $issue->id,
            'Official solution updated for issue: ' . $issue->title
        );

        return redirect()->back()->with('success', 'Official technical solution has been saved and published to the portal.');
    }

    public function updateStatus(Request $request, $id)
    {
        $issue = IndustryTechIssue::findOrFail($id);
        $status = $request->input('status');

        if (in_array($status, ['open', 'in_progress', 'solved', 'closed'])) {
            $issue->update(['status' => $status]);

            ActivityLog::record(
                'status_changed',
                'industry_tech_issues',
                $issue->id,
                "Status changed to {$status} for issue: " . $issue->title
            );

            return redirect()->back()->with('success', "Status updated to " . ucfirst(str_replace('_', ' ', $status)));
        }

        return redirect()->back()->with('error', 'Invalid status provided.');
    }

    public function deleteReply($issueId, $replyId)
    {
        $reply = IndustryTechIssueReply::where('issue_id', $issueId)->findOrFail($replyId);
        $reply->delete();

        $issue = IndustryTechIssue::find($issueId);
        if ($issue) {
            $issue->decrement('replies_count');
        }

        return redirect()->back()->with('success', 'Discussion reply removed.');
    }

    public function destroy($id)
    {
        $issue = IndustryTechIssue::findOrFail($id);
        $title = $issue->title;
        $issue->delete();

        ActivityLog::record(
            'issue_deleted',
            'industry_tech_issues',
            $id,
            'Deleted technical issue: ' . $title
        );

        return redirect()->route('admin.industry-tech-issues.index')->with('success', 'Issue deleted successfully.');
    }
}
