<?php

namespace App\Http\Controllers;

use App\Models\IndustryTechIssue;
use App\Models\IndustryTechIssueReply;
use App\Models\IndustryTechIssueVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IndustryTechIssueController extends Controller
{
    public function index(Request $request)
    {
        $query = IndustryTechIssue::where('is_active', true);

        // Search
        if ($search = trim($request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('industry_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%")
                  ->orWhere('solution', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        // Urgency filter
        if ($urgency = $request->input('urgency')) {
            $query->where('urgency', $urgency);
        }

        // Tag filter
        if ($tag = $request->input('tag')) {
            $query->where('tags', 'like', "%{$tag}%");
        }

        $issues = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Categories with counts
        $categories = [
            'Fabric Defects' => IndustryTechIssue::where('category', 'Fabric Defects')->count(),
            'Dyeing Issues' => IndustryTechIssue::where('category', 'Dyeing Issues')->count(),
            'Weaving Defects' => IndustryTechIssue::where('category', 'Weaving Defects')->count(),
            'Finishing Problems' => IndustryTechIssue::where('category', 'Finishing Problems')->count(),
            'Testing & Quality' => IndustryTechIssue::where('category', 'Testing & Quality')->count(),
            'Spinning' => IndustryTechIssue::where('category', 'Spinning')->count(),
        ];

        $totalIssuesCount = IndustryTechIssue::count();
        $solvedCount = IndustryTechIssue::where('status', 'solved')->count();
        $openCount = IndustryTechIssue::where('status', 'open')->count();

        return view('front.industry-tech-issues.index', compact(
            'issues',
            'categories',
            'totalIssuesCount',
            'solvedCount',
            'openCount'
        ));
    }

    public function show($slug)
    {
        $issue = IndustryTechIssue::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $replies = $issue->approvedReplies;
        $ip = request()->ip();
        $hasVoted = $issue->hasVotedByIp($ip);

        // Related issues in same category
        $relatedIssues = IndustryTechIssue::where('category', $issue->category)
            ->where('id', '!=', $issue->id)
            ->take(4)
            ->get();

        return view('front.industry-tech-issues.show', compact('issue', 'replies', 'hasVoted', 'relatedIssues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'industry_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'urgency' => 'required|string|in:Low,Medium,High,Critical',
            'description' => 'required|string|max:5000',
            'tags' => 'nullable|string|max:255',
        ]);

        $issue = IndustryTechIssue::create([
            'title' => $validated['title'],
            'industry_name' => $validated['industry_name'],
            'contact_person' => $validated['contact_person'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
            'description' => $validated['description'],
            'tags' => $validated['tags'] ?? null,
            'status' => 'open',
            'is_active' => true,
        ]);

        return redirect()->route('industry-tech-issues.show', $issue->slug)
            ->with('success', 'Your technical issue has been reported successfully! Textiles Committee experts and industry peers will review and reply.');
    }

    public function reply(Request $request, $id)
    {
        $issue = IndustryTechIssue::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'industry' => 'nullable|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:3000',
        ]);

        IndustryTechIssueReply::create([
            'issue_id' => $issue->id,
            'name' => $validated['name'],
            'industry' => $validated['industry'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'is_approved' => true,
        ]);

        $issue->increment('replies_count');

        return redirect()->back()->with('success', 'Your response has been published successfully.');
    }

    public function vote(Request $request, $id)
    {
        $issue = IndustryTechIssue::findOrFail($id);
        $ip = $request->ip();

        $existing = IndustryTechIssueVote::where('issue_id', $issue->id)
            ->where('ip_address', $ip)
            ->first();

        if ($existing) {
            $existing->delete();
            $issue->decrement('upvotes_count');
            $voted = false;
        } else {
            IndustryTechIssueVote::create([
                'issue_id' => $issue->id,
                'ip_address' => $ip,
                'session_id' => session()->getId(),
            ]);
            $issue->increment('upvotes_count');
            $voted = true;
        }

        $freshVotes = $issue->fresh()->upvotes_count;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'voted' => $voted,
                'upvotes_count' => $freshVotes,
            ]);
        }

        return redirect()->back()->with('success', $voted ? 'Upvote recorded!' : 'Upvote removed.');
    }
}
