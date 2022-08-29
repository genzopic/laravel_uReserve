<div>
    {{-- Do your work, then step back. --}}
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input type="text" wire:model="name"><br>
        @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
        <label for="email">メール</label>
        <input type="email" wire:model.lazy="email"><br>
        @error('email') <div class="text-red-600">{{ $message }}</div> @enderror
        <label for="password">パスワード</label>
        <input type="password" wire:model="password"><br>
        @error('password') <div class="text-red-600">{{ $message }}</div> @enderror
        <button class="px-4 py-2 border bg-blue-600 hover:bg-blue-400 text-white">登録する</button>
    </form>
</div>
