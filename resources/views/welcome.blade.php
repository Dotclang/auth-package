@extends('AuthPackage::layouts.app')

@section('content')
    <main class="min-h-screen w-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
        <section class="w-full px-4 py-12 mx-auto ">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sm:p-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div class="sm:flex-1">
                        <h1 class="text-2xl sm:text-3xl font-semibold leading-tight">Dotclang Design Studio</h1>
                        <p class="mt-3 text-gray-600 dark:text-gray-300">We craft thoughtful, accessible interfaces and
                            product experiences for web and mobile — design systems, UI components, and front-end
                            engineering with TailwindCSS.</p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            @include('AuthPackage::components.button', [
                                'label' => 'View Services',
                                'href' => '#services',
                            ])
                            @include('AuthPackage::components.button', [
                                'label' => 'Contact Us',
                                'href' => '#contact',
                                'variant' => 'outline',
                            ])
                        </div>
                    </div>

                    <div class="sm:w-72">
                        <img src="/vendor/Dotclang/auth-package/images/office-illustration.svg" alt="Office illustration"
                            class="w-full h-auto rounded-md bg-gray-50 dark:bg-gray-700 p-2" />
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="px-4 pb-12 mx-auto max-w-5xl">
            <h2 class="text-xl font-semibold mb-6">What we do</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('AuthPackage::components.feature-card', [
                    'title' => 'Product Design',
                    'body' => 'User research, wireframes, and high-fidelity UI for web and mobile.',
                    'icon' => '🎨',
                ])
                @include('AuthPackage::components.feature-card', [
                    'title' => 'Design Systems',
                    'body' => 'Reusable components, tokens, and documentation to scale UI consistently.',
                    'icon' => '🧩',
                ])
                @include('AuthPackage::components.feature-card', [
                    'title' => 'Front-end Engineering',
                    'body' => 'Accessible, performant front-ends built with TailwindCSS and modern tooling.',
                    'icon' => '⚡',
                ])
            </div>
        </section>

        <section id="about" class="px-4 pb-12 mx-auto max-w-4xl">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium">About us</h3>
                <p class="mt-3 text-gray-600 dark:text-gray-300">We are a small multidisciplinary team focusing on
                    delivering delightful, accessible interfaces. We pair design with engineering to ship production-ready
                    UI and documentation.</p>
            </div>
        </section>

        <section id="contact" class="px-4 pb-20 mx-auto max-w-4xl">
            <div
                class="bg-gradient-to-r from-white/50 dark:from-gray-800/50 to-white/30 dark:to-gray-800/30 border border-gray-100 dark:border-gray-700 rounded-lg p-6">
                <h3 class="text-lg font-medium">Get in touch</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Email us at <a href="mailto:hello@dotclang.com"
                        class="text-indigo-600 dark:text-indigo-400 underline">hello@dotclang.com</a> or use the form in
                    your host application.</p>
            </div>
        </section>
    </main>
@endsection
