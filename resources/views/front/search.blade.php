@extends('layouts.front')

@section('content')
<div class="py-4" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <h2 class="fw-bold fs-2" style="color: var(--gov-maroon);">
            खोज परिणाम / Search Results
        </h2>
        <p class="text-muted fs-5 m-0">"{{ $q }}" के लिए प्राप्त परिणाम:</p>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <!-- Schemes -->
        <h3 class="fw-bold fs-3 mb-3" style="color: var(--gov-maroon);">योजनाएं और सेवाएं ({{ $schemes->count() }})</h3>
        <div class="list-group mb-5 shadow-sm">
            @forelse($schemes as $s)
                <a href="{{ $s->link_url ?? '#' }}" class="list-group-item list-group-item-action p-3">
                    <h5 class="fw-bold fs-4 mb-1">{{ $s->title_hi }}</h5>
                    <p class="text-muted fs-5 m-0">{{ $s->description_hi }}</p>
                </a>
            @empty
                <div class="list-group-item p-3 text-muted">कोई योजना नहीं मिली।</div>
            @endforelse
        </div>

        <!-- Documents -->
        <h3 class="fw-bold fs-3 mb-3" style="color: var(--gov-maroon);">दस्तावेज़ ({{ $documents->count() }})</h3>
        <div class="list-group mb-5 shadow-sm">
            @forelse($documents as $d)
                <a href="{{ asset($d->file_url ?? 'assets/images/sample_doc.pdf') }}" target="_blank" class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold fs-4 mb-1">{{ $d->title_hi }}</h5>
                        <p class="text-muted fs-5 m-0">{{ $d->description_hi }}</p>
                    </div>
                    <span class="badge bg-danger fs-6 px-3 py-2">Download PDF</span>
                </a>
            @empty
                <div class="list-group-item p-3 text-muted">कोई दस्तावेज़ नहीं मिला।</div>
            @endforelse
        </div>

        <!-- Tenders -->
        <h3 class="fw-bold fs-3 mb-3" style="color: var(--gov-maroon);">निविदाएं एवं रिक्तियां ({{ $tenders->count() }})</h3>
        <div class="list-group shadow-sm">
            @forelse($tenders as $t)
                <a href="{{ asset($t->document_url ?? 'assets/images/sample_doc.pdf') }}" target="_blank" class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold fs-4 mb-1">{{ $t->title_hi }}</h5>
                        <small class="text-muted">संदर्भ: {{ $t->reference_no }} | अंतिम तिथि: {{ $t->closing_date ? $t->closing_date->format('d-m-Y') : 'अद्यतन' }}</small>
                    </div>
                    <span class="badge bg-primary fs-6 px-3 py-2">देखें</span>
                </a>
            @empty
                <div class="list-group-item p-3 text-muted">कोई निविदा या रिक्ति नहीं मिली।</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
