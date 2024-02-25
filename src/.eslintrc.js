module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    "plugin:vue/vue3-recommended",
    "eslint:recommended",
    "plugin:prettier/recommended",
  ],
  plugins: [
    "vue",
    "prettier",
  ],
  globals: {
    "axios": "readonly"
  },
  rules: {
    "vue/no-v-html": "off",
    "vue/prop-name-casing": "off",
    "no-console": "off",
    "no-unused-vars": "off",
    "camelcase": "off",
    "vue/multi-word-component-names": "off",
    "indent": ["error", "tab"],
    "no-tabs": "off"
  },
}