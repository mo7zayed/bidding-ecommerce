
export default {
    mode: 'universal',
    /*
    ** Headers of the page
    */
    head: {
        title: process.env.npm_package_name || '',
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: process.env.npm_package_description || '' }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
        ]
    },
    /*
    ** Customize the progress-bar color
    */
    loading: { color: '#27aac7' },
    /*
    ** Global CSS
    */
    css: [
        '~assets/app.scss',
    ],
    /*
    ** Plugins to load before mounting the App
    */
    plugins: [
    ],
    /*
    ** Nuxt.js dev-modules
    */
    buildModules: [
        // Doc: https://github.com/nuxt-community/eslint-module
        '@nuxtjs/eslint-module'
    ],
    /*
    ** Nuxt.js modules
    */
    modules: [
        // Doc: https://axios.nuxtjs.org/usage
        '@nuxtjs/axios',
        // Doc: https://auth.nuxtjs.org
        '@nuxtjs/auth',
    ],

    /*
    ** Axios module configuration
    ** See https://axios.nuxtjs.org/options
    */
    axios: {
        baseURL: 'http://127.0.0.1:8000/api/',
    },

    /*
    ** Auth module configuration
    ** See https://auth.nuxtjs.org/guide/setup.html
    */
    auth: {
        strategies: {
            local: {
                endpoints: {
                    login: {
                        url: 'auth/login',
                        method: 'POST',
                        propertyName: 'payload.access_token',
                    },
                    user: {
                        url: 'auth/me',
                        method: 'POST',
                        propertyName: 'payload.user',
                    },
                    logout: {
                        url: 'auth/logout',
                        method: 'POST',
                    },
                },
            },
        },
    },

    /*
    ** Build configuration
    */
    build: {
        postcss: {
            preset: {
                features: {
                    customProperties: false
                }
            }
        },
        /*
        ** You can extend webpack config here
        */
        extend (config, ctx) {
        }
    }
}
