module.exports = {
  css: {
    loaderOptions: {
      sass: {
        additionalData: `
          @import "@/assets/styles/mixins.scss";
          @import "@/assets/styles/variables.scss";
        `,
      },
    },
  },
};