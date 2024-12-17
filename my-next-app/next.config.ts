/** @type {import('next').NextConfig} */
const nextConfig = {
  output: 'export',
  images: {
    unoptimized: true
  },
  // Remove the assetPrefix setting
  // Add basePath if you're serving from a subdirectory
  // basePath: '/subdirectory',
}

module.exports = nextConfig