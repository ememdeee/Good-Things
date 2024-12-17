import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import { Navigation } from '@/components/navigation'
import { Footer } from '@/components/footer'
import { SupportButton } from '@/components/support-button'
import './globals.css'

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
  title: 'VehicleInsights - Vehicle History Reports & Window Stickers',
  description: 'Get comprehensive vehicle history reports and original window stickers. Sell your car faster with complete documentation and verified history.',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en" className="scroll-smooth">
      <body className={inter.className}>
        <Navigation />
        <main>{children}</main>
        <SupportButton />
        <Footer />
      </body>
    </html>
  )
}

