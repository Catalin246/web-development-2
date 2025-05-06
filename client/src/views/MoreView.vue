<template>
    <div class="py-4 md:p-8 w-full">
      <div class="max-w-xl mx-auto bg-white rounded-xl p-4 space-y-4">
        <h2 class="text-2xl font-semibold">Settings</h2>
  
        <div class="space-y-4">
          <div class="flex justify-between items-center">
            <span class="text-gray-700">Notifications</span>
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" />
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-700">Dark Mode</span>
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" />
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-700">Privacy Mode</span>
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" />
          </div>
        </div>
  
        <button
          class="mt-6 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
        >
          Log Out
        </button>
      </div>
    </div>
  </template>
  