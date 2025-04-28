// @ts-check
import { defineConfig } from 'astro/config';
import 'dotenv/config';
const BASE_URL = process.env.SITE_DOMAIN || 'http://localhost:3000';
const BASE_HOST = process.env.SITE_HOST || 'localhost';

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
    allowedHosts: [ BASE_HOST ]
  },
  output: 'static',
  integrations: [playformCompress()],
});
