<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.menus.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fs-6 fw-bold">Edit Menu Item: {{ $item->title_en }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Menu Title (English) <span class="text-danger">*</span></label>
                        <input type="text" name="title_en" class="form-control" required value="{{ $item->title_en }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Menu Title (Hindi)</label>
                        <input type="text" name="title_hi" class="form-control" value="{{ $item->title_hi }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Parent Menu (Dropdown Level)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- None (Top Level Navigation Tab) --</option>
                            @if(isset($parentOptions))
                                @foreach($parentOptions as $opt)
                                    @if($opt->id !== $item->id)
                                        <option value="{{ $opt->id }}" {{ $item->parent_id == $opt->id ? 'selected' : '' }}>
                                            {!! $opt->title !!}
                                        </option>
                                    @endif
                                @endforeach
                            @elseif(isset($topMenus))
                                @foreach($topMenus as $parent)
                                    @if($parent->id !== $item->id)
                                        <option value="{{ $parent->id }}" {{ $item->parent_id == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->title_en }} (Dropdown)
                                        </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted">Select any Main Menu or Submenu to place this item inside it.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Link Type <span class="text-danger">*</span></label>
                        <select name="type" id="editMenuType{{ $item->id }}" class="form-select" onchange="toggleEditInputs{{ $item->id }}(this.value)">
                            <option value="page" {{ $item->type === 'page' ? 'selected' : '' }}>Link to CMS Dynamic Page</option>
                            <option value="custom" {{ $item->type === 'custom' ? 'selected' : '' }}>Custom URL or Anchor (#)</option>
                        </select>
                    </div>

                    <!-- Option A: CMS Page Selector -->
                    <div class="mb-3 {{ $item->type === 'custom' ? 'd-none' : '' }}" id="editPageGroup{{ $item->id }}">
                        <label class="form-label fw-semibold">Select CMS Page</label>
                        <select name="page_id" class="form-select">
                            <option value="">-- Choose a CMS Page --</option>
                            @foreach($allPages as $pg)
                                <option value="{{ $pg->id }}" {{ $item->page_id == $pg->id ? 'selected' : '' }}>
                                    {{ $pg->title_en }} (/page/{{ $pg->slug }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Option B: Custom URL -->
                    <div class="mb-3 {{ $item->type === 'page' ? 'd-none' : '' }}" id="editCustomGroup{{ $item->id }}">
                        <label class="form-label fw-semibold">Custom URL / Anchor</label>
                        <input type="text" name="url" class="form-control" value="{{ $item->url }}" placeholder="e.g. #keyOfferings or https://example.com">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Target</label>
                            <select name="target" class="form-select">
                                <option value="_self" {{ $item->target === '_self' ? 'selected' : '' }}>Same Tab (_self)</option>
                                <option value="_blank" {{ $item->target === '_blank' ? 'selected' : '' }}>New Tab (_blank)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}" min="0">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editActive{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="editActive{{ $item->id }}">Enabled / Visible</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-cms-primary btn-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleEditInputs{{ $item->id }}(val) {
        if (val === 'custom') {
            document.getElementById('editPageGroup{{ $item->id }}').classList.add('d-none');
            document.getElementById('editCustomGroup{{ $item->id }}').classList.remove('d-none');
        } else {
            document.getElementById('editPageGroup{{ $item->id }}').classList.remove('d-none');
            document.getElementById('editCustomGroup{{ $item->id }}').classList.add('d-none');
        }
    }
</script>
