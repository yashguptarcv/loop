<script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Primary colors (updated from image)
                        'primary': {
                            100: '#024A3F',
                            200: '#0E6558',
                            300: '#326E64',
                            400: '#527A74',
                            500: '#5B7F79',
                            600: '#6C8984',
                            700: '#A2B6B3',
                            800: '#0369a1',
                            900: '#075985',
                        },

                        // New color palette from image
                        'amber': {
                            100: '#FFB90C', // R255 G185 B12
                            200: '#C9930A', // R201 G147 B10
                            300: '#B08009', // R176 G128 B9
                            400: '#8C6607', // R140 G102 B7
                            500: '#6A4C05', // R106 G76 B5
                            600: '#523B04', // R82 G59 B4
                            700: '#3B2A03', // R59 G42 B3
                            800: '#241902', // R36 G25 B2
                        },

                        'teal': {
                            50: '#001817', // R0 G24 B23
                            100: '#02443F', // R2 G68 B63
                            200: '#066558', // R6 G101 B88
                            300: '#236564', // R35 G101 B100
                            400: '#527A74', // R82 G122 B116
                            500: '#5F7779', // R95 G119 B121
                            600: '#6C8964', // R108 G137 B100
                            700: '#A2B683', // R162 G182 B131
                        },


                        // // Glass morphism colors
                        // 'glass': {
                        //   'light': 'rgba(255, 255, 255, 0.15)',
                        //   'dark': 'rgba(0, 0, 0, 0.15)',
                        //   'border-light': 'rgba(255, 255, 255, 0.18)',
                        //   'border-dark': 'rgba(0, 0, 0, 0.18)',
                        // },

                        // Special colors
                        'neon': {
                            'blue': '#00f5ff',
                            'pink': '#ff00e4',
                            'purple': '#8a2be2',
                        },
                    },

                    // Gradient color stops
                    gradientColorStops: ({
                        theme
                    }) => ({
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
        }
    </script>