@if(isset($items) && count($items) !== 0)
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="px-2 py-1 mb-0 mr-2 text-sm text-muted">
                Menampilkan {{$items->firstItem()}} s/d {{$items->lastItem()}} dari {{$items->total()}} Total Data
            </div>
            @if($items->hasPages())
                {{ $items->withQueryString()->links('pagination::bootstrap-4') }}
            @else
                <div class="pagination">
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="page-link disabled" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    <div aria-current="page">
                        <span class="page-link active" aria-hidden="true">1</span>
                    </div>
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="page-link disabled" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                </div>
            @endif
        </div>
    </div>
@elseif(isset($rows) && count($rows) !== 0)
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="px-2 py-1 mb-0 mr-2 text-sm text-muted">
                Menampilkan {{$rows->firstItem()}} s/d {{$rows->lastItem()}} dari {{$rows->total()}} Total Data
            </div>
            @if($rows->hasPages())
                {{ $rows->withQueryString()->links('pagination::bootstrap-4') }}
            @else
                <div class="pagination">
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="page-link disabled" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    <div aria-current="page">
                        <span class="page-link active" aria-hidden="true">1</span>
                    </div>
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="page-link disabled" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="px-2 py-1 mb-0 mr-2 text-sm text-muted">
                Tidak ada data ditemukan
            </div>
            <div class="pagination">
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="page-link disabled" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                <div aria-current="page">
                    <span class="page-link active" aria-hidden="true">1</span>
                </div>
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="page-link disabled" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
            </div>
        </div>
    </div>
@endif
