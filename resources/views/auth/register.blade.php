<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Personal Information -->
        <div class="mb-4">
            <h5 class="text-primary">Personal Information</h5>
        </div>

        <!-- Name -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mb-3">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Professional Information -->
        <div class="mb-4 mt-6">
            <h5 class="text-primary">Professional Information</h5>
        </div>

        <!-- Bar Number -->
        <div class="mb-3">
            <x-input-label for="bar_number" :value="__('Bar Number')" />
            <x-text-input id="bar_number" class="block mt-1 w-full" type="text" name="bar_number" :value="old('bar_number')" required />
            <x-input-error :messages="$errors->get('bar_number')" class="mt-2" />
        </div>

        <!-- License State -->
        <div class="mb-3">
            <x-input-label for="license_state" :value="__('License State')" />
            <x-text-input id="license_state" class="block mt-1 w-full" type="text" name="license_state" :value="old('license_state')" required />
            <x-input-error :messages="$errors->get('license_state')" class="mt-2" />
        </div>

        <!-- Years of Experience -->
        <div class="mb-3">
            <x-input-label for="years_of_experience" :value="__('Years of Experience')" />
            <x-text-input id="years_of_experience" class="block mt-1 w-full" type="number" name="years_of_experience" :value="old('years_of_experience', 0)" min="0" required />
            <x-input-error :messages="$errors->get('years_of_experience')" class="mt-2" />
        </div>

        <!-- Firm Name -->
        <div class="mb-3">
            <x-input-label for="firm_name" :value="__('Firm Name (Optional)')" />
            <x-text-input id="firm_name" class="block mt-1 w-full" type="text" name="firm_name" :value="old('firm_name')" />
            <x-input-error :messages="$errors->get('firm_name')" class="mt-2" />
        </div>

        <!-- Bio -->
        <div class="mb-3">
            <x-input-label for="bio" :value="__('Professional Bio (Optional)')" />
            <textarea id="bio" name="bio" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('bio') }}</textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register as Lawyer') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>