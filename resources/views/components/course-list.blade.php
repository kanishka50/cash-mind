<div class="mt-4 overflow-hidden shadow-md rounded-lg border border-gray-800">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-darker">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Course
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Videos
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Progress
                    </th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-card divide-y divide-gray-700">
                @forelse ($courses as $course)
                <tr class="hover:bg-darker transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 rounded-md overflow-hidden">
                                @if ($course->thumbnail)
                                    <img class="h-12 w-12 object-cover" src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                                @else
                                    <div class="h-12 w-12 bg-darker flex items-center justify-center">
                                        <svg class="h-6 w-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">
                                    {{ $course->title }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ Str::limit($course->description, 50) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($course->category)
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-teal bg-opacity-10 text-accent-teal">
                                {{ $course->category->name }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-700 text-gray-300">
                                Uncategorized
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-accent-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            {{ $course->videos->count() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="relative pt-1">
                            <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-gray-700">
                                <div style="width: {{ $course->progress_percentage ?? 0 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-accent-teal"></div>
                            </div>
                            <div class="text-xs text-gray-400">{{ $course->progress_percentage ?? 0 }}% complete</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('user.courses.show', $course) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-accent-teal text-white hover:bg-opacity-80 transition-all duration-300">
                            <span>Continue</span>
                            <svg class="ml-1.5 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 whitespace-nowrap text-sm text-gray-400 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            <p>You haven't purchased any courses yet.</p>
                            <a href="{{ route('courses.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-accent-teal rounded-md text-white hover:bg-opacity-80 transition-all duration-300">
                                Browse Courses
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>