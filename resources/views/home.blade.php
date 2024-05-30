@extends('welcome')

@section('content')
    {{-- below nav bar, the whole section with BG --}}
    <section class="bg-white py-12 px-4 sm:px-6 lg:px-8 h-screen relative overflow-hidden">
        <!-- Blurred Background -->
        <div class="absolute inset-0 bg-gradient-to-r from-pink-300 to-blue-800 opacity-50 filter blur-3xl"></div>

        <div class="max-w-7xl mx-auto h-full flex flex-col justify-center relative z-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    XYZ Marketing Company
                </h2>
                <p class="mt-4 text-lg text-gray-500">
                    Marketing is the process of promoting and selling products or services to potential customers.
                    It
                    involves understanding consumer needs and desires, creating compelling messaging and branding,
                    and
                    strategically communicating with target audiences through various channels such as advertising,
                    social media, email campaigns, and more. Effective marketing helps businesses build brand
                    awareness,
                    generate leads, and ultimately drive sales. It's a dynamic and ever-evolving field that requires
                    creativity, strategic thinking, and continuous adaptation to changing consumer behaviors and
                    market
                    trends.
                </p>
                <div class="mt-6">
                    <a href="#"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md transition duration-300 hover:bg-blue-600">Learn
                        More</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT US --}}
    <section class="aboutus py-10 bg-white" id="aboutus">
        <h2 class="text-4xl text-center font-semibold">About Us</h2>
        <div class="flex flex-col lg:flex-row lg:justify-between mt-10">

            <div class="flex flex-col lg:shadow-2xl shadow-lg mx-10 p-5 mt-5 lg:mt-0 rounded-lg">
                <p class="font-bold text-2xl text-center">Strategic Campaigns</p>
                <img src="{{ asset('src_images/aboutUs.png') }}" alt="About Us" class="mx-auto">
                <p class="mt-3">The marketing company specializes in crafting strategic and impactful marketing
                    campaigns tailored to the unique needs of each client. From comprehensive digital strategies to
                    traditional marketing approaches, they design campaigns that effectively reach the target
                    audience
                    and achieve measurable results.</p>
            </div>

            <div class="flex flex-col lg:shadow-2xl shadow-sm mx-10 p-5 mt-5 lg:mt-0 rounded-lg">
                <p class="font-bold text-2xl text-center">Innovative Digital Solutions</p>
                <img src="{{ asset('src_images/aboutUs.png') }}" alt="About Us" class="mx-auto">
                <p class="mt-3">Leveraging the power of digital platforms, the company is at the forefront of
                    innovation. They provide cutting-edge solutions in areas such as social media marketing, search
                    engine optimization (SEO), and content marketing. Their expertise in the digital landscape
                    ensures
                    clients stay ahead in the competitive online environment.</p>
            </div>

            <div class="flex flex-col lg:shadow-2xl shadow-sm mx-10 p-5 mt-5 lg:mt-0 rounded-lg">
                <p class="font-bold text-2xl text-center">Data-Driven Insights</p>
                <img src="{{ asset('src_images/aboutUs.png') }}" alt="About Us" class="mx-auto">
                <p class="mt-3">With a commitment to data-driven decision-making, the marketing company employs
                    advanced analytics tools to gather insights into consumer behavior and campaign performance. By
                    analyzing data meticulously, they refine strategies, optimize campaigns in real-time, and
                    provide
                    clients with clear, measurable results, fostering continuous improvement.</p>
            </div>
        </div>
    </section>

    <br>
    <br>
    <br>
    {{-- TRUSTED PARTNERS --}}
    <section class="trustedpartners bg-slate-200 py-10">
        <div>
            <h2 class="text-4xl font-semibold text-center">Our Trusted Partners</h2>
            <div class="flex lg:h-20 mt-20 h-10 md:justify-around justify-around">
                <img src="{{ asset('src_images/trust1.png') }}" alt="apple">
                <img src="{{ asset('src_images/trust2.png') }}" alt="google">
                <img src="{{ asset('src_images/trust3.png') }}" alt="facebook">
                <img src="{{ asset('src_images/trust4.png') }}" alt="amazon">
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section class="bg-gray-100 py-16" id="services">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Our Services</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Social Media Marketing</h3>
                    <p class="text-gray-600">Boost your online presence and engage with your audience through
                        strategic
                        social media campaigns.</p>
                </div>
                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Search Engine Optimization</h3>
                    <p class="text-gray-600">Improve your website's visibility on search engines and drive organic
                        traffic to your site.</p>
                </div>
                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Email Marketing</h3>
                    <p class="text-gray-600">Reach out to your target audience effectively with personalized email
                        campaigns and newsletters.</p>
                </div>
                <!-- Add more services as needed -->
            </div>
        </div>
    </section>

    {{-- PRICING --}}
    <section class="bg-gray-100 py-16" id="pricing">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">Choose Your Plan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Pricing Tier 1 -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Basic</h3>
                    <p class="text-gray-600 mb-4">Ideal for individuals or small businesses.</p>
                    <p class="text-3xl font-bold text-gray-800 mb-4">$9.99<span class="text-base font-normal">/month</span>
                    </p>
                    <ol class="text-gray-600 list-inside list-decimal">
                        <li class="mb-2">Social Media Marketing</li>
                        <li class="mb-2">Follow-up within 2-3 business days</li>
                    </ol>
                    <button class="block bg-blue-500 text-white px-4 py-2 rounded-md mt-6">Select Plan</button>
                </div>

                <!-- Pricing Tier 2 -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Standard</h3>
                    <p class="text-gray-600 mb-4">Perfect for growing businesses.</p>
                    <p class="text-3xl font-bold text-gray-800 mb-4">$19.99<span class="text-base font-normal">/month</span>
                    </p>
                    <ol class="text-gray-600 list-inside list-decimal">
                        <li class="mb-2">Social Media Marketing</li>
                        <li class="mb-2">Email Marketing</li>
                        <li class="mb-2">Follow-up within 24 hours</li>
                    </ol>
                    <button class="block bg-blue-500 text-white px-4 py-2 rounded-md mt-6">Select Plan</button>
                </div>

                <!-- Pricing Tier 3 -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Premium</h3>
                    <p class="text-gray-600 mb-4">For large enterprises with advanced needs.</p>
                    <p class="text-3xl font-bold text-gray-800 mb-4">$29.99<span class="text-base font-normal">/month</span>
                    </p>
                    <ol class="text-gray-600 list-inside list-decimal">
                        <li class="mb-2">Social Media Marketing</li>
                        <li class="mb-2">Email Marketing</li>
                        <li class="mb-2">Search Engine Optimization</li>
                        <li class="mb-2">Instant follow-up from technical team</li>
                    </ol>
                    <button class="block bg-blue-500 text-white px-4 py-2 rounded-md mt-6">Select Plan</button>
                </div>
            </div>
        </div>
    </section>
@endsection
