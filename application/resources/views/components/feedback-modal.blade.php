@if(session('show_feedback'))
<div class="modal fade show d-block" id="feedbackModal" tabindex="-1" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold text-center w-100">
                    Bagaimana pengalaman Anda hari ini?
                </h5>
            </div>

            <div class="modal-body">

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf

                    {{-- Rating --}}
                    <div class="d-flex justify-content-between text-center mb-4">
                        @php
                            $emotes = [
                                1 => ['icon' => '😡', 'label' => 'Buruk'],
                                2 => ['icon' => '😟', 'label' => 'Kurang'],
                                3 => ['icon' => '😐', 'label' => 'Cukup'],
                                4 => ['icon' => '🙂', 'label' => 'Baik'],
                                5 => ['icon' => '🤩', 'label' => 'Puas'],
                            ];
                        @endphp

                        @foreach($emotes as $value => $data)
                        <label class="rating-item">
                            <input type="radio" name="rating" value="{{ $value }}" required>
                            <div class="emoji">{{ $data['icon'] }}</div>
                            <small>{{ $data['label'] }}</small>
                        </label>
                        @endforeach
                    </div>

                    {{-- Feature --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Apakah fitur pencatatan anggaran membantu?
                        </label>
                        <select name="feature_score" class="form-select">
                            <option value="yes">Ya, sangat membantu</option>
                            <option value="neutral">Biasa saja</option>
                            <option value="no">Tidak, terlalu rumit</option>
                        </select>
                    </div>

                    {{-- Comment --}}
                    <div class="mb-3">
                        <textarea name="comment" rows="3"
                            class="form-control"
                            placeholder="Saran & kritik..."
                            required></textarea>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        Kirim Feedback
                    </button>
                </form>

                {{-- Tombol Nanti Saja --}}
                <form action="{{ route('feedback.dismiss') }}" method="GET">
                    <button type="submit"
                            class="btn btn-outline-secondary w-100 text-muted mt-2">
                        Nanti Saja
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/loadingtombolhandler.js') }}"></script>
@endif