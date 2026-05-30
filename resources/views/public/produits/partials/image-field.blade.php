@props(['currentUrl' => null, 'inputId' => 'image'])

<div class="am-image-upload" data-am-image-upload>
    <div class="am-field">
        <label for="{{ $inputId }}">Photo du produit</label>
        <input id="{{ $inputId }}" name="image" type="file" accept="image/jpeg,image/png,image/webp" data-am-image-input>
        <p class="am-field-hint">JPEG, PNG ou WebP — max. 4 Mo. Stockée dans votre espace vendeur.</p>
    </div>
    @if($currentUrl)
        <div class="am-image-preview" data-am-image-preview>
            <img src="{{ $currentUrl }}" alt="Image actuelle">
            <label class="am-image-remove">
                <input type="checkbox" name="remove_image" value="1">
                Supprimer cette image
            </label>
        </div>
    @else
        <div class="am-image-preview am-image-preview--empty d-none" data-am-image-preview>
            <img src="" alt="Aperçu">
        </div>
    @endif
</div>
