import { PricingCards } from '@/components/pricing-card'

export default function PricingPage() {
  return (
    <section className="py-16 bg-gradient-to-br from-blue-50 via-white to-purple-50">
      <div className="container px-4 mx-auto">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <h1 className="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">
            Choose Your Vehicle History Report Plan
          </h1>
          <p className="text-lg text-gray-600 mb-8">
            Access comprehensive vehicle data from official sources including DMV, auctions, police records, 
            state records, insurance, and NMVTIS databases. Save up to 50% compared to CarFax for the same detailed reports.
          </p>
        </div>

        <PricingCards />

        <div className="mt-12 text-center">
          <p className="text-sm text-gray-600">
            All plans include our 30-day money-back guarantee. No questions asked.
          </p>
        </div>
      </div>
    </section>
  )
}

