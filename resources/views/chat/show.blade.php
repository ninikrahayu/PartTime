@extends($layout)
@section('title', 'Chat - Partimeku')
@section('page_title', 'Pesan')

@section('content')
<div class="max-w-4xl mx-auto space-y-4">

    <!-- Header -->
    <div class="flex items-center gap-4 border-b border-border-color pb-4">
        <a href="{{ $backUrl }}" class="w-10 h-10 flex items-center justify-center rounded-md bg-white border border-border-color text-text-gray hover:bg-surface transition-colors shrink-0">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="flex items-center gap-3 min-w-0">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=1E3A8A&color=fff&size=80" alt="{{ $otherUser->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-surface shadow-sm shrink-0">
            <div class="min-w-0">
                <h2 class="text-base font-bold text-text-dark truncate">{{ $otherUser->name }}</h2>
                <p class="text-xs text-text-gray truncate">
                    <i class="fa-solid fa-briefcase mr-1"></i>{{ $lamaran->lowongan->judul ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div id="chat-messages" class="bg-white rounded-lg border border-border-color shadow-sm overflow-hidden">
        <div class="h-[460px] overflow-y-auto p-4 space-y-3" id="messages-scroll">
            @if($messages->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <i class="fa-solid fa-comments text-primary text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-text-dark">Belum ada pesan</p>
                    <p class="text-xs text-text-gray mt-1">Mulai percakapan dengan mengirim pesan pertama.</p>
                </div>
            @else
                @php $lastDate = null; @endphp
                @foreach($messages as $msg)
                    @php
                        $msgDate = $msg->created_at->format('d M Y');
                        $isMe = $msg->sender_id === Auth::id();
                    @endphp

                    @if($msgDate !== $lastDate)
                        <div class="flex justify-center my-2">
                            <span class="text-[10px] text-text-gray bg-surface px-3 py-1 rounded-full border border-border-color">{{ $msgDate }}</span>
                        </div>
                        @php $lastDate = $msgDate; @endphp
                    @endif

                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] {{ $isMe ? 'bg-primary text-white' : 'bg-surface text-text-dark border border-border-color' }} rounded-2xl {{ $isMe ? 'rounded-br-md' : 'rounded-bl-md' }} px-4 py-2.5 shadow-sm">
                            <p class="text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $msg->body }}</p>
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[10px] {{ $isMe ? 'text-blue-200' : 'text-text-gray' }}">{{ $msg->created_at->format('H:i') }}</span>
                                @if($isMe && $msg->read_at)
                                    <i class="fa-solid fa-check-double text-[10px] text-blue-200"></i>
                                @elseif($isMe)
                                    <i class="fa-solid fa-check text-[10px] text-blue-200"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Input Area -->
        <div class="border-t border-border-color bg-surface p-3">
            <form action="{{ url('/chat/' . $lamaran->id) }}" method="POST" class="flex items-end gap-2">
                @csrf
                <div class="flex-1">
                    <textarea name="body" rows="1" placeholder="Tulis pesan..." required
                        class="w-full resize-none rounded-xl border border-border-color bg-white px-4 py-2.5 text-sm text-text-dark placeholder:text-text-gray focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                        onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.form.submit();}"
                        oninput="this.style.height='auto';this.style.height=Math.min(this.scrollHeight,120)+'px';"
                    ></textarea>
                </div>
                <button type="submit" class="h-10 w-10 shrink-0 flex items-center justify-center rounded-xl bg-primary text-white hover:bg-blue-900 transition-colors shadow-sm">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-3 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-scroll');
        if (container) container.scrollTop = container.scrollHeight;
    });
</script>
@endpush
@endsection
