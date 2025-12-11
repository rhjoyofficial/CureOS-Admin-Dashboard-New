@extends('layouts.guest')

@section('title', 'Verify Email')

@section('card-header', 'Verify Your Email Address')

@section('content')
    <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just
        emailed to you? If you didn't receive the email, we will gladly send you another.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-green-600">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mt-3 sm:mt-0 text-sm text-gray-600 hover:text-gray-900 underline">
                Log Out
            </button>
        </form>
    </div>
@endsection
