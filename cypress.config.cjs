// cypress.config.cjs
const { defineConfig } = require('cypress')

module.exports = defineConfig({
    e2e: {
        projectId: "fj8czh",
        baseUrl: 'http://127.0.0.1:8000', // Ou o URL do seu app Laravel
        setupNodeEvents(on, config) {
            // implement node event listeners here
        },
    },
})
