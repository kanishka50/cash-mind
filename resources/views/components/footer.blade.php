<footer class="bg-darker border-t border-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4 text-primary-400">Cash Mind</h3>
                <p class="text-gray-300">
                    Empowering financial education in Sri Lanka through accessible and comprehensive courses.
                </p>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4 text-gray-200">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Home</a></li>
                    <li><a href="{{ route('courses') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Courses</a></li>
                    <li><a href="{{ route('digital-products') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Digital Products</a></li>
                    <li><a href="{{ route('subscription-plans') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Subscriptions</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4 text-gray-200">Support</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Contact Us</a></li>
                    <li><a href="{{ route('faqs') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">FAQs</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Terms of Service</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-primary-400 transition duration-200">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4 text-gray-200">Connect With Us</h4>
                <div class="flex space-x-4">
                    <a href="https://www.youtube.com/@cashmindsl2004" target="_blank" class="text-gray-400 hover:text-primary-400 transition duration-200">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-400 transition duration-200">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-400 transition duration-200">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} Cash Mind. All rights reserved.
            </p>
        </div>
    </div>
</footer>