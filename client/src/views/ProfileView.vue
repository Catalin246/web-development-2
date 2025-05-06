<template>
    <div class="p-4 md:p-8 w-full">
      <div class="max-w-xl mx-auto bg-white shadow rounded-xl p-6 space-y-4">
        <div class="flex items-center space-x-4">
          <img
            src="https://randomuser.me/api/portraits/men/8.jpg"
            class="w-16 h-16 rounded-full"
            alt="User Avatar"
          />
          <div>
            <h2 class="text-xl font-semibold">John Doe</h2>
            <p class="text-gray-500">johndoe@example.com</p>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <input
            type="text"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
            placeholder="Busy, at work, etc."
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">About</label>
          <textarea
            rows="3"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
            placeholder="Say something about yourself"
          ></textarea>
        </div>
        <button
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Save
        </button>
      </div>
    </div>
  </template>
  