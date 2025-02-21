@props(['modal_id', 'modal_title'])

<div id="{{ $modal_id }}" class="modal" data-modal-target="{{ $modal_id }}">
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ $modal_title }}</h2>
            <button class="close-btn" id="closeModalBtn">&times;</button>
        </div>
            <div class="modal-body">

            {{ $slot }}

            </div>
     </div>
</div>