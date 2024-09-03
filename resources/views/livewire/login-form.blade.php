<div>
    <div style="color:red; text-align: center;padding:10px">@error('error') {{ $message }} @enderror</div>
    <form class="user" wire:submit.prevent="login">
        <div class="form-group">
            <input type="username" class="form-control form-control-user @error('username')is-invalid @enderror" id="username" wire:model="username" autocomplete="off"
                id="exampleInputusername" aria-describedby="usernameHelp" style="font-size: 1rem"
                placeholder="firstname.lastname">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password')is-invalid @enderror" wire:model="password"
                id="exampleInputPassword" placeholder="Password"style="font-size: 1rem">
                <div style="color:red; text-align: center;padding:10px">@error('password') {{ $message }} @enderror</div>
        </div>
        <button class="btn btn-primary btn-user btn-block" style="font-size: 1rem">
            Login
        </button>
    </form>
</div>
