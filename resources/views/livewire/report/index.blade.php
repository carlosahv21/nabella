<div>
    <!-- notifications -->
    <div class="position-fixed top-2 end-2 z-index-2">
        <div class="toast fade hide p-2 bg-white bg-gradient-{{ session('alert.type', 'info') }}" role="alert" aria-live="assertive" id="toast" data-bs-delay="2000">
            <div class="toast-header bg-transparent text-white border-0">
                <i class="material-icons me-2">
                    {{ session('alert.icon') }}
                </i>
                <span class="me-auto font-weight-bold">Notification!</span>
                <i class="material-icons cursor-pointer" data-bs-dismiss="toast" aria-label="Close">close</i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white ">
                {{ session('alert.message') }}
            </div>
        </div>
    </div>
    <!-- end notifications -->
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-7 col-lg-7 d-md-flex">
                <!-- Selector de fechas -->
                <div class="input-group me-3 w-50">
                    <input type="text" class="form-control date-input-range" placeholder="Select a date range" wire:model="date_range" style="border: 1px solid #d2d6da">
                </div>
                <!-- Selector de servicios -->
                <div class="input-group me-3 w-50">
                    <select wire:model="service_contract_id" class="form-select" id="service_contract_id">
                        <option value="">Select a service</option>
                        @foreach($service_contracts as $service_contract)
                        <option value="{{ $service_contract->id }}">{{ $service_contract->company }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group w-50">
                    <select wire:model="terms" class="form-select" id="terms">
                        <option value="">Select a term</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
            <div class="col-4 col-lg-4 d-flex justify-content-end mt-3 me-4">
                <button class="btn bg-gradient-dark" wire:click="generateReport" wire:loading.attr="disabled">
                    <i class="material-icons">picture_as_pdf</i> Generate Report
                </button>
            </div>
        </div>
    </div>
    
    @if($invoice)
    <div>
        <iframe src="{{ asset($invoice) }}" width="100%" class="pdf-frame p-2" style="height: 1500px;"></iframe>
    </div>
    @endif
</div>