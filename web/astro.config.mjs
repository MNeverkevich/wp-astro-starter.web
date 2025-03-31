// @ts-check
import { defineConfig } from 'astro/config';
import 'dotenv/config';
const BASE_URL = process.env.SITE_DOMAIN;

import tailwindcss from '@tailwindcss/vite';
import playformCompress from '@playform/compress';

// https://astro.build/config
export default defineConfig({
  site: BASE_URL,
  vite: {
    plugins: [
      tailwindcss(),
    ]
  },

  server: {
    port: 3000,
    host: true,
  },
  output: 'static',
  integrations: [playformCompress()],
});