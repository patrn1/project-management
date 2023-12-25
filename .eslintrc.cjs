module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'airbnb-base',
    'plugin:vue/vue3-essential',
  ],
  overrides: [
    {
      env: {
        node: true,
      },
      files: [
        '.eslintrc.{js,cjs}',
      ],
      parserOptions: {
        sourceType: 'script',
      }
    },
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'vue',
  ],
  rules: {
    "import/no-extraneous-dependencies": "off",
    "max-len": "off",
    "no-use-before-define": "off",
    "vue/multi-word-component-names": "off",
    "no-return-assign": "off",
    "no-param-reassign": "off",
    "camelcase": "off",
  },
  settings: {
    'import/resolver': {
      alias: {
        map: [['@', './resources/js']],
        extensions: ['.js', '.vue'],
      },
    },
  },
  globals: {
      route: true,
  }
};
