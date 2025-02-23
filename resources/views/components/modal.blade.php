@props(['modal_id', 'modal_title'])

<div id="{{ $modal_id }}" class="modal" data-modal-target="{{ $modal_id }}">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">{{ $modal_title }}</h2>

            <div class="modal-header-buttons">
                @if($modal_id === 'Show_prod_card')
                    <button type="button" class="close-btn" id="editModalBtn">✏️</button>
                    <button type="button" class="delete-product-btn">🗑️</button>
                @endif

                <button class="close-btn" id="closeModalBtn">&times;</button>
            </div>
        </div>
            <div class="modal-body">

            {{ $slot }}

            </div>
     </div>
</div>