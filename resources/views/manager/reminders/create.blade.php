<x-manager-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Send Email to {{ $user->name }}</h1>
            <p class="mt-2 text-lg text-gray-600">Compose and send a manual email reminder</p>
        </div>

        <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('manager.reminders.send-manual') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="space-y-4">
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               value="{{ old('subject', '✨ Special Message from Sally Salon') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                               required>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="8"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Hello {{ $user->name }}, 💖&#10;&#10;We hope you're having a beautiful day! ✨&#10;&#10;We wanted to reach out and remind you that Sally Salon is here to help you look and feel your absolute best. Whether you're ready for a fresh new look, a relaxing treatment, or just want to pamper yourself, our talented team is excited to welcome you back! 💅&#10;&#10;Book your next appointment with us and let us help you shine! 🌟&#10;&#10;With love and beauty,&#10;The Sally Salon Team 💕&#10;&#10;📞 Call us: 09319309716&#10;📧 Email: ptc.johnalexishubilla@gmail.com"
                                  required>{{ old('message') }}</textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="javascript:history.back()" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Send Email
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-manager-layout>