<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#1a1b26] via-[#16161e] to-[#222436] text-white px-4">
    <div class="w-full max-w-md bg-[#24283b] rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold mb-6 text-center text-[#7aa2f7]">Tokyo Night Shortener</h1>
      <form @submit.prevent="shortenUrl" class="space-y-4">
        <div>
          <label class="block mb-1 text-[#bb9af7]">Original URL</label>
          <input v-model="originalUrl" type="url" required placeholder="https://example.com" class="w-full px-3 py-2 rounded bg-[#1a1b26] border border-[#414868] focus:outline-none focus:ring-2 focus:ring-[#7aa2f7]" />
        </div>
        <div>
          <label class="block mb-1 text-[#bb9af7]">Custom Alias (optional)</label>
          <input v-model="alias" type="text" placeholder="your-alias" class="w-full px-3 py-2 rounded bg-[#1a1b26] border border-[#414868] focus:outline-none focus:ring-2 focus:ring-[#7aa2f7]" />
        </div>
        <button type="submit" class="w-full py-2 rounded bg-[#7aa2f7] hover:bg-[#3d59a1] font-semibold transition">Shorten</button>
      </form>
      <div v-if="shortUrl" class="mt-6 bg-[#1a1b26] rounded p-4 text-center border border-[#414868]">
        <div class="mb-2 text-[#7dcfff]">Short URL:</div>
        <a :href="shortUrl" target="_blank" class="text-[#7aa2f7] underline break-all">{{ shortUrl }}</a>
        <button @click="copyToClipboard" class="ml-2 px-2 py-1 bg-[#bb9af7] text-[#24283b] rounded hover:bg-[#7aa2f7] transition">Copy</button>
        <div v-if="copied" class="text-xs text-[#9ece6a] mt-2">Copied!</div>
      </div>
      <div v-if="error" class="mt-4 text-[#f7768e] text-center">{{ error }}</div>
    </div>
    <footer class="mt-8 text-[#565f89] text-xs">Inspired by Tokyo Night Theme</footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const originalUrl = ref('');
const alias = ref('');
const shortUrl = ref('');
const error = ref('');
const copied = ref(false);

const shortenUrl = async () => {
  error.value = '';
  shortUrl.value = '';
  copied.value = false;
  try {
    const response = await fetch('/shorten', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content,
      },
      body: JSON.stringify({
        original_url: originalUrl.value,
        alias: alias.value || undefined,
      }),
    });
    const data = await response.json();
    if (response.ok) {
      shortUrl.value = data.short_url;
    } else {
      error.value = data.message || 'Failed to shorten URL.';
    }
  } catch (e) {
    error.value = 'Server error.';
  }
};

const copyToClipboard = () => {
  if (shortUrl.value) {
    navigator.clipboard.writeText(shortUrl.value);
    copied.value = true;
    setTimeout(() => (copied.value = false), 1500);
  }
};
</script>

<style scoped>
body {
  font-family: 'Fira Mono', 'Fira Code', 'JetBrains Mono', 'monospace';
}
</style>
