const defaultCopyConfig = require('@ionic/app-scripts/config/copy.config');

module.exports = {
  ...defaultCopyConfig,

  copyFonts: {
    src: [
      ...defaultCopyConfig.copyFonts.src,
      '{{ROOT}}/node_modules/font-proxima-nova/fonts/**/*',
    ],
    dest: defaultCopyConfig.copyFonts.dest,
  },
};