// tailwind.config.ts

import type { Config } from 'tailwindcss'

export default {
  content: [
    './*.html',
    './*.php',
    './**/*.php',
    './src/**/*.{js,ts}'
  ],
  theme: {
    extend: {
      colors: {
        'logo-header': 'var(--color-logo-header)',
        'titulo-header': 'var(--color-titulo-header)',
        'dividing-bar': 'var(--color-dividing-bar)',
        'ponto-lista': 'var(--color-ponto-lista)',
        'leia-tambem': 'var(--color-leia-tambem)',
        'categoria': 'var(--color-categoria)',
        'paginacao': 'var(--color-paginacao)',
        'link': 'var(--color-link)',
        'botao-flutuante': 'var(--color-botao-flutuante)',
        'botao-flutuante-bloco': 'var(--color-botao-flutuante-bloco)',
      },
      animation: {
        'float': 'float 6s ease-in-out infinite',
        'fade-in': 'fadeIn 0.8s ease-out',
        'slide-up': 'slideUp 0.6s ease-out',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' }
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        slideUp: {
          '0%': { transform: 'translateY(30px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        }
      }
    },
  },
  plugins: [],
} satisfies Config