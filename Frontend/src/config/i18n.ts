export const defaultLocale = 'ja';
export const fallbackLocale = 'en';

export const locales = [
  { code: 'en', iso: 'en-US', file: 'en/index.ts' },
  { code: 'ja', iso: 'ja-JP', file: 'ja/index.ts' },
];

export const dateTimeFormats = {
  'en-US': {
    short: {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    },
  },
  'ja-JP': {
    short: {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    },
  },
};

export const numberFormats = {
  'en-US': {
    currency: {
      style: 'currency',
      currency: '$',
    },
  },
  'ja-JP': {
    currency: {
      style: 'currency',
      currency: '¥',
    },
  },
};

export default {
  numberFormats,
  dateTimeFormats,
  locales,
};
