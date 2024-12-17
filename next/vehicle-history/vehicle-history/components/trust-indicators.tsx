import Image from 'next/image'

export function TrustIndicators() {
  return (
    <section className="border-y bg-white py-12">
      <div className="container mx-auto px-4">
        <div className="text-center mb-8">
          <p className="text-lg font-semibold">
            Trusted globally by <span className="text-blue-600">1,000,000+</span> users 
            across <span className="text-blue-600">150+</span> nations
          </p>
        </div>
        <div className="grid grid-cols-3 md:grid-cols-6 gap-8 items-center justify-items-center opacity-70">
          {[1, 2, 3, 4, 5, 6].map((i) => (
            <Image
              key={i}
              src="/placeholder.svg"
              alt={`Trust Badge ${i}`}
              width={120}
              height={40}
              className="h-8 w-auto"
            />
          ))}
        </div>
      </div>
    </section>
  )
}

