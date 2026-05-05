@auth
    <div class="modal fade app-modal" id="planModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <span class="app-eyebrow mb-2">
                            <i class="las la-bolt"></i>
                            @lang('Confirm investment')
                        </span>
                        <h3 class="modal-title method-name mb-0" id="planModalLabel">@lang('Investment plan')</h3>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="@lang('Close')"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('user.investment') }}" method="post" class="disableSubmission">
                        @csrf

                        <input type="hidden" name="id" required>

                        <div class="app-card mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <span class="app-list-icon"><i class="las la-info-circle"></i></span>
                                <div>
                                    <h4 class="fs-6 fw-bold mb-1">@lang('Before you continue')</h4>
                                    <p class="mb-0 text-muted">@lang('Enter an amount within this plan range. The system will validate the amount again when you confirm.')</p>
                                    <div class="app-pills" id="planRangeWrap" hidden>
                                        <span class="app-pill">
                                            <i class="las la-compress-arrows-alt"></i>
                                            <span id="planRangeText"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2" for="amount">@lang('Investment amount')</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control" name="amount" required value="{{ old('amount') }}" inputmode="decimal"
                                    placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                <span class="input-group-text bg-white border-0 fw-bold">{{ __(gs('cur_text')) }}</span>
                            </div>
                            <small class="text-muted d-block mt-2">@lang('You can adjust this before pressing confirm.')</small>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" class="app-btn w-100" style="background: rgba(15, 23, 42, .08); color: #0b2033;" data-bs-dismiss="modal">
                                    @lang('Close')
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="app-btn w-100" style="color:#fff; background: linear-gradient(135deg, #1268f3, #13c8d6);">
                                    <i class="las la-check"></i>
                                    @lang('Confirm')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth

@auth
    @push('script')
        <script>
            (function() {
                "use strict";

                const defaultPlanName = @json(__('Investment plan'));

                document.querySelectorAll('.planModal').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const modal = document.getElementById('planModal');
                        if (!modal) return;

                        modal.querySelector('input[name=id]').value = this.dataset.id || '';
                        modal.querySelector('#planModalLabel').textContent = this.dataset.name || defaultPlanName;

                        const min = this.dataset.min;
                        const max = this.dataset.max;
                        const rangeWrap = modal.querySelector('#planRangeWrap');
                        const rangeText = modal.querySelector('#planRangeText');

                        if (min && max && rangeWrap && rangeText) {
                            rangeText.textContent = `${min} - ${max} {{ gs('cur_text') }}`;
                            rangeWrap.hidden = false;
                        } else if (rangeWrap) {
                            rangeWrap.hidden = true;
                        }
                    });
                });
            })();
        </script>
    @endpush
@endauth
