<form method="POST" wire:submit.prevent="submit" class="input-wrapper input-wrapper-inline ml-lg-5">
    <input type="text" class="form-control" wire:model.lazy="phone" placeholder="Masukan Nomer Handphone..." />
    @error('phone')
    <span class="has-error">{{ $message }}</span>
    @enderror
    @if($success)
    <span class="has-error">Subsribe successed!</span>
    @endif
    <button class="btn btn-primary btn-md ml-2" type="submit">Subsribe<i class="d-icon-arrow-right"></i></button>
</form>