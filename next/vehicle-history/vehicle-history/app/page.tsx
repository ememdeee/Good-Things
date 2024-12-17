import { Hero } from '@/components/hero'
import { TrustIndicators } from '@/components/trust-indicators'
import { Stats } from '@/components/stats'
import { Features } from '@/components/features'
import { SellerAdvantage } from '@/components/seller-advantage'
import { MarketValueSection } from '@/components/market-value-section'
import { BoostSaleSection } from '@/components/boost-sale-section'
import { WindowStickerSection } from '@/components/window-sticker-section'
import { TrustStats } from '@/components/trust-stats'
import { CustomerSupportSection } from '@/components/customer-support-section'
import { TrustBadgesSection } from '@/components/trust-badges-section'

export default function Home() {
  return (
    <>
      <Hero />
      <TrustIndicators />
      <Stats />
      <Features />
      <SellerAdvantage />
      <TrustStats />
      <BoostSaleSection />
      <WindowStickerSection />
      <MarketValueSection />
      <CustomerSupportSection />
      <TrustBadgesSection />
    </>
  )
}

