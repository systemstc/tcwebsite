@extends('layouts.admin')

@section('title', 'Social Media Feeds Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h5 class="cms-card-title d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-primary">share</span> Social Media Feeds (Front-end Cards)
            </h5>
            <small class="text-muted">Manage the posts, video links, tweets, and reels displayed in the 4 scrollable social cards on the homepage.</small>
        </div>
        <a href="{{ route('admin.social-posts.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Social Post Link
        </a>
    </div>

    <!-- Quick Add Box: Paste Link Only -->
    <div class="p-3 bg-white border-bottom" style="background: linear-gradient(to right, #fbf7f9, #ffffff); border-left: 4px solid var(--cms-primary) !important;">
        <form action="{{ route('admin.social-posts.quick-store') }}" method="POST">
            @csrf
            <div class="row g-2 align-items-center">
                <div class="col-md-9 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white text-danger">
                            <span class="material-symbols-outlined" style="font-size: 20px;">bolt</span>
                        </span>
                        <input type="url" name="post_url" class="form-control form-control-lg" placeholder="Just paste any X/Twitter, YouTube, Facebook, or Instagram post link here..." required>
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-cms-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-1">
                        <span class="material-symbols-outlined" style="font-size: 18px;">add_circle</span> Auto Add Post
                    </button>
                </div>
            </div>
        </form>
        <div class="small text-muted mt-2 d-flex align-items-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles text-warning"></i>
            <span><strong>100% Dynamic:</strong> Just paste the link! The platform, video thumbnail, title, and post content are automatically extracted and published to the front-end feed.</span>
        </div>
    </div>

    <!-- Platform Filter Tabs -->
    <div class="p-3 border-bottom bg-light d-flex flex-wrap align-items-center gap-2">
        <span class="fw-bold small text-muted me-2">Filter Platform:</span>
        <a href="{{ route('admin.social-posts.index') }}" class="btn btn-sm {{ !request('platform') ? 'btn-dark' : 'btn-outline-secondary' }}">
            All Platforms ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.social-posts.index', ['platform' => 'twitter']) }}" class="btn btn-sm {{ request('platform') === 'twitter' ? 'btn-dark' : 'btn-outline-secondary' }}">
            <i class="fa-brands fa-x-twitter me-1"></i> X / Twitter ({{ $counts['twitter'] }})
        </a>
        <a href="{{ route('admin.social-posts.index', ['platform' => 'youtube']) }}" class="btn btn-sm {{ request('platform') === 'youtube' ? 'btn-danger' : 'btn-outline-danger' }}">
            <i class="fa-brands fa-youtube me-1"></i> YouTube ({{ $counts['youtube'] }})
        </a>
        <a href="{{ route('admin.social-posts.index', ['platform' => 'facebook']) }}" class="btn btn-sm {{ request('platform') === 'facebook' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fa-brands fa-facebook-f me-1"></i> Facebook ({{ $counts['facebook'] }})
        </a>
        <a href="{{ route('admin.social-posts.index', ['platform' => 'instagram']) }}" class="btn btn-sm {{ request('platform') === 'instagram' ? 'btn-danger' : 'btn-outline-secondary' }}" style="{{ request('platform') === 'instagram' ? 'background: #e4405f; border-color: #e4405f;' : '' }}">
            <i class="fa-brands fa-instagram me-1"></i> Instagram ({{ $counts['instagram'] }})
        </a>
    </div>

    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">Media</th>
                        <th style="width: 140px;">Platform</th>
                        <th>Title / Post Content</th>
                        <th>Target Post Link</th>
                        <th style="width: 80px;">Order</th>
                        <th style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <img src="{{ $post->getDisplayImage() }}" alt="Preview" style="height: 48px; width: 68px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='{{ asset('assets/images/hero_auditorium.png') }}'">
                            </td>
                            <td>
                                @if($post->platform === 'twitter')
                                    <span class="badge bg-dark d-inline-flex align-items-center gap-1">
                                        <i class="fa-brands fa-x-twitter"></i> X (Twitter)
                                    </span>
                                @elseif($post->platform === 'youtube')
                                    <span class="badge bg-danger d-inline-flex align-items-center gap-1">
                                        <i class="fa-brands fa-youtube"></i> YouTube
                                    </span>
                                @elseif($post->platform === 'facebook')
                                    <span class="badge bg-primary d-inline-flex align-items-center gap-1">
                                        <i class="fa-brands fa-facebook-f"></i> Facebook
                                    </span>
                                @else
                                    <span class="badge d-inline-flex align-items-center gap-1" style="background: linear-gradient(45deg, #f09433, #dc2743, #bc1888);">
                                        <i class="fa-brands fa-instagram"></i> Instagram
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $post->title ?: Str::limit($post->content, 45, '...') }}</div>
                                @if($post->content && $post->title)
                                    <small class="text-muted d-block text-truncate" style="max-width: 320px;">{{ $post->content }}</small>
                                @endif
                                <div class="small text-muted mt-1">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $post->post_date ?? 'Recent' }}
                                    @if($post->likes_count)
                                        <span class="ms-2"><i class="fa-regular fa-heart text-danger"></i> {{ $post->likes_count }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ $post->post_url }}" target="_blank" class="small text-decoration-none text-primary d-inline-flex align-items-center gap-1" title="Open Link">
                                    <span class="text-truncate" style="max-width: 200px;">{{ $post->post_url }}</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $post->sort_order }}</span>
                            </td>
                            <td>
                                @if($post->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.social-posts.edit', $post->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.social-posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this social post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <span class="material-symbols-outlined d-block mb-1" style="font-size: 36px; opacity: 0.5;">info</span>
                                No social media posts found for this filter. Click "Add New Social Post Link" to add one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-3 border-top">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
