// vite.config.js
import { defineConfig } from "file:///C:/xampp/htdocs/administrative/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/xampp/htdocs/administrative/node_modules/laravel-vite-plugin/dist/index.js";
import tailwindcss from "file:///C:/xampp/htdocs/administrative/node_modules/@tailwindcss/vite/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/css/soliera.css",
        "resources/css/sidebar-collapse.css",
        "resources/css/icon-standardization.css",
        "resources/js/app.js",
        "resources/js/notification-websocket.js"
      ],
      refresh: true
    }),
    tailwindcss()
  ],
  build: {
    target: "es2022",
    manifest: true,
    outDir: "public/build",
    emptyOutDir: true,
    rollupOptions: {
      output: {
        manualChunks: void 0
      }
    }
  },
  server: {
    host: "localhost",
    port: 5173,
    strictPort: true,
    hmr: {
      host: "localhost"
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcYWRtaW5pc3RyYXRpdmVcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXHhhbXBwXFxcXGh0ZG9jc1xcXFxhZG1pbmlzdHJhdGl2ZVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzoveGFtcHAvaHRkb2NzL2FkbWluaXN0cmF0aXZlL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB0YWlsd2luZGNzcyBmcm9tICdAdGFpbHdpbmRjc3Mvdml0ZSc7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3Mvc29saWVyYS5jc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL3NpZGViYXItY29sbGFwc2UuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Nzcy9pY29uLXN0YW5kYXJkaXphdGlvbi5jc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL25vdGlmaWNhdGlvbi13ZWJzb2NrZXQuanMnXG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIHRhaWx3aW5kY3NzKCksXG4gICAgXSxcbiAgICBidWlsZDoge1xuICAgICAgICB0YXJnZXQ6ICdlczIwMjInLFxuICAgICAgICBtYW5pZmVzdDogdHJ1ZSxcbiAgICAgICAgb3V0RGlyOiAncHVibGljL2J1aWxkJyxcbiAgICAgICAgZW1wdHlPdXREaXI6IHRydWUsXG4gICAgICAgIHJvbGx1cE9wdGlvbnM6IHtcbiAgICAgICAgICAgIG91dHB1dDoge1xuICAgICAgICAgICAgICAgIG1hbnVhbENodW5rczogdW5kZWZpbmVkLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIHNlcnZlcjoge1xuICAgICAgICBob3N0OiAnbG9jYWxob3N0JyxcbiAgICAgICAgcG9ydDogNTE3MyxcbiAgICAgICAgc3RyaWN0UG9ydDogdHJ1ZSxcbiAgICAgICAgaG1yOiB7XG4gICAgICAgICAgICBob3N0OiAnbG9jYWxob3N0JyxcbiAgICAgICAgfSxcbiAgICB9XG59KTsiXSwKICAibWFwcGluZ3MiOiAiO0FBQW9SLFNBQVMsb0JBQW9CO0FBQ2pULE9BQU8sYUFBYTtBQUNwQixPQUFPLGlCQUFpQjtBQUV4QixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsWUFBWTtBQUFBLEVBQ2hCO0FBQUEsRUFDQSxPQUFPO0FBQUEsSUFDSCxRQUFRO0FBQUEsSUFDUixVQUFVO0FBQUEsSUFDVixRQUFRO0FBQUEsSUFDUixhQUFhO0FBQUEsSUFDYixlQUFlO0FBQUEsTUFDWCxRQUFRO0FBQUEsUUFDSixjQUFjO0FBQUEsTUFDbEI7QUFBQSxJQUNKO0FBQUEsRUFDSjtBQUFBLEVBQ0EsUUFBUTtBQUFBLElBQ0osTUFBTTtBQUFBLElBQ04sTUFBTTtBQUFBLElBQ04sWUFBWTtBQUFBLElBQ1osS0FBSztBQUFBLE1BQ0QsTUFBTTtBQUFBLElBQ1Y7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
