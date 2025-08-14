// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        // Primary colors
        'primary': {
          50: '#f0f9ff',
          100: '#e0f2fe',
          200: '#bae6fd',
          300: '#7dd3fc',
          400: '#38bdf8',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
          800: '#075985',
          900: '#0c4a6e',
        },
        
        // Danger/Error colors
        'danger': {
          50: '#fef2f2',
          100: '#fee2e2',
          200: '#fecaca',
          300: '#fca5a5',
          400: '#f87171',
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
          800: '#991b1b',
          900: '#7f1d1d',
        },
        
        // Success colors
        'success': {
          50: '#f0fdf4',
          100: '#dcfce7',
          200: '#bbf7d0',
          300: '#86efac',
          400: '#4ade80',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
          800: '#166534',
          900: '#14532d',
        },
        
        // Warning colors
        'warning': {
          50: '#fffbeb',
          100: '#fef3c7',
          200: '#fde68a',
          300: '#fcd34d',
          400: '#fbbf24',
          500: '#f59e0b',
          600: '#d97706',
          700: '#b45309',
          800: '#92400e',
          900: '#78350f',
        },
        
        // Dark theme colors
        'dark': {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
        },
        
        // Gradient colors
        'gradient': {
          'purple': '#8B5CF6',
          'indigo': '#6366F1',
          'blue': '#3B82F6',
          'teal': '#14B8A6',
          'pink': '#EC4899',
        },
        
        // Glass morphism colors
        'glass': {
          'light': 'rgba(255, 255, 255, 0.15)',
          'dark': 'rgba(0, 0, 0, 0.15)',
          'border-light': 'rgba(255, 255, 255, 0.18)',
          'border-dark': 'rgba(0, 0, 0, 0.18)',
        },
        
        // Special colors
        'neon': {
          'blue': '#00f5ff',
          'pink': '#ff00e4',
          'purple': '#8a2be2',
        },
      },
      
      // Gradient color stops
      gradientColorStops: ({ theme }) => ({
        ...theme('colors'),
        'gradient-start': '#8B5CF6',
        'gradient-middle': '#6366F1',
        'gradient-end': '#3B82F6',
      }),
    },
  },
  variants: {
    extend: {
      backgroundColor: ['active', 'disabled'],
      textColor: ['active', 'disabled'],
      opacity: ['disabled'],
      cursor: ['disabled'],
    },
  },
//   plugins: [
//     require('@tailwindcss/forms'),
//     require('@tailwindcss/typography'),
//   ],
}