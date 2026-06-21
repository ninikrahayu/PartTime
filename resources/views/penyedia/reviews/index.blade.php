@extends('layouts.penyedia')

@section('title', 'Review Penyedia - Partimeku')
@section('page_title', 'Review')

@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-medium text-primary">Review Penyedia</p>
        <h2 class="mt-1 text-2xl font-semibold text-text-dark">Reputasi dan Review</h2>
        <p class="mt-1 text-sm text-text-gray">Pantau review yang diterima dari mahasiswa dan review yang diberikan ke mahasiswa.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-dashboard-summary-card label="Rating Rata-rata" :value="$provider['average_rating'] ?? 0" icon="fa-star" />
        <x-dashboard-summary-card label="Review Diterima" :value="$receivedReviews->count()" icon="fa-comments" />
        <x-dashboard-summary-card label="Review Diberikan" :value="$givenReviews->count()" icon="fa-pen-to-square" />
        <x-dashboard-summary-card label="Total Review Profil" :value="$provider['reviews_count'] ?? 0" icon="fa-chart-line" />
    </div>

    <div class="rounded-md border border-border-color bg-white shadow-sm">
        <div class="border-b border-border-color px-5">
            <nav class="-mb-px flex gap-6 overflow-x-auto">
                <button id="review-tab-received" type="button" onclick="switchReviewTab('received')" class="whitespace-nowrap border-b-2 border-primary px-1 py-4 text-sm font-medium text-primary">
                    Review Diterima
                </button>
                <button id="review-tab-given" type="button" onclick="switchReviewTab('given')" class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-text-gray hover:border-border-color hover:text-text-dark">
                    Review Diberikan
                </button>
            </nav>
        </div>

        <div id="review-panel-received" class="p-5">
            <div class="grid gap-4 lg:grid-cols-2">
                @forelse($receivedReviews as $review)
                    @php
                        $data = [
                            'reviewer_name' => $review->reviewer->name ?? 'Mahasiswa',
                            'job_title' => optional(optional($review->lamaran)->lowongan)->judul ?? '-',
                            'rating' => $review->rating,
                            'comment' => $review->comment,
                            'reviewer_role' => 'Mahasiswa',
                            'created_at' => $review->created_at->format('d M Y, H:i')
                        ];
                    @endphp
                    <x-review-card :review="$data" />
                @empty
                    <div class="lg:col-span-2">
                        <x-empty-state title="Belum ada review diterima" description="Review dari mahasiswa akan tampil setelah pekerjaan selesai." />
                    </div>
                @endforelse
            </div>
        </div>

        <div id="review-panel-given" class="hidden p-5">
            <div class="grid gap-4 lg:grid-cols-2">
                @forelse($givenReviews as $review)
                    <article class="rounded-md border border-border-color bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold text-text-dark">{{ $review->reviewee->name ?? 'Mahasiswa' }}</h3>
                                <p class="mt-1 text-sm text-text-gray">{{ optional(optional($review->lamaran)->lowongan)->judul ?? '-' }}</p>
                            </div>
                            <div class="flex shrink-0 items-center gap-1 text-secondary">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star text-sm"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-text-gray">{{ $review->comment ?? '-' }}</p>
                        <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-text-gray">
                            <x-badge color="gray">Diberikan ke Mahasiswa</x-badge>
                            <span>{{ $review->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </article>
                @empty
                    <div class="lg:col-span-2">
                        <x-empty-state title="Belum ada review diberikan" description="Review yang diberikan ke mahasiswa akan tampil di sini." />
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchReviewTab(activeTab) {
        const tabs = ['received', 'given'];

        tabs.forEach((tab) => {
            const button = document.getElementById(`review-tab-${tab}`);
            const panel = document.getElementById(`review-panel-${tab}`);
            const isActive = tab === activeTab;

            if (button) {
                button.classList.toggle('border-primary', isActive);
                button.classList.toggle('text-primary', isActive);
                button.classList.toggle('border-transparent', !isActive);
                button.classList.toggle('text-text-gray', !isActive);
            }

            if (panel) {
                panel.classList.toggle('hidden', !isActive);
            }
        });
    }
</script>
@endpush
