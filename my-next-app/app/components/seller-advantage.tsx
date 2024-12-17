import Image from 'next/image'
import { Button } from '@/components/ui/button'

export function SellerAdvantage() {
  return (
    <section className="py-20 bg-white">
      <div className="container mx-auto px-4">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="space-y-6">
            <h2 className="text-3xl font-bold">
              The Smart Seller&apos;s Advantage
            </h2>
            <div className="space-y-4">
              <div className="border-l-4 border-blue-600 pl-4">
                <h3 className="font-bold text-xl mb-2">Faster Sales</h3>
                <p className="text-gray-600">
                  Cars with verified history reports sell up to 30% faster than those without.
                </p>
              </div>
              <div className="border-l-4 border-blue-600 pl-4">
                <h3 className="font-bold text-xl mb-2">Better Prices</h3>
                <p className="text-gray-600">
                  Documentation builds trust, leading to higher offers from serious buyers.
                </p>
              </div>
              <div className="border-l-4 border-blue-600 pl-4">
                <h3 className="font-bold text-xl mb-2">Original Details</h3>
                <p className="text-gray-600">
                  Window stickers showcase your vehicle&apos;s original features and value.
                </p>
              </div>
            </div>
            <Button size="lg" className="mt-6">
              Get Your Report Now
            </Button>
          </div>
          <div className="relative">
            <Image
              src="/Unlock the Secrets of Your Window Sticker.png"
              alt="Vehicle Report Example"
              width={600}
              height={400}
              className=""
            />
          </div>
        </div>
      </div>
    </section>
  )
}

