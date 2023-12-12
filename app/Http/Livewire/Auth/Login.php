<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Auth\Events\Login as AuthLogin; // Alias the Login class
use Illuminate\Http\Request; // Import the Request class

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected array $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];
 /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Dispatch the Login event to capture the user who logs in
        event(new AuthLogin('web', Auth::user(), $this->boolean('remember'))); // Use the aliased class name

        $this->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
