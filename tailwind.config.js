import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './node_modules/flowbite/**/*.js',
  ],

  theme: {
    extend: {

      /* flotar imagen */
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-12px)' },
        },
      },
      animation: {
        float: 'float 6s ease-in-out infinite',
      },


      /* flowbite */
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'neutral-primary-soft': '#f3f4f6',
        'neutral-primary-medium': '#e5e7eb',
        'neutral-secondary-soft': '#f9fafb',
        'neutral-tertiary-medium': '#d1d5db',
        'text-heading': '#111827',
        'text-body': '#6b7280',
        'fg-brand': '#3b82f6',
        'fg-danger-strong': '#b91c1c',
        'danger-soft': '#fee2e2',
        'border-default': '#d1d5db',
        'border-default-medium': '#9ca3af',
        'border-danger-subtle': '#fecaca',
      },
      borderRadius: {
        base: '0.5rem',
        sm: '0.125rem',
      },
      spacing: {
        '4.5': '1.125rem',
        '2': '0.5rem',
        '3': '0.75rem',
        '24': '6rem',
      },
    },
  },

  plugins: [
    forms,
    typography,
    require('flowbite/plugin'),
  ],
};
