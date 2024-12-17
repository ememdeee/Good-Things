import Image from 'next/image'

export function TrustIndicators() {
  const trustBadges = [
    { src: "/business-times-journal.webp", alt: "Business Times Journal" },
    { src: "/canada-business-today.webp", alt: "Canada Business Today" },
    { src: "/the-america-watch.webp", alt: "The America Watch" },
    { src: "/north-america.webp", alt: "North America" },
  ]

  return (
    <section className="border-y bg-white py-12">
      <div className="container mx-auto px-4">
        <div className="text-center mb-8">
          <p className="text-lg font-semibold">
            Trusted globally by <span className="text-blue-600">1,000,000+</span> users 
            across <span className="text-blue-600">150+</span> nations
          </p>
        </div>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
          {trustBadges.map((badge, index) => (
            <div key={index} className="flex items-center justify-center h-16">
              <Image
                src={badge.src}
                alt={badge.alt}
                width={200}
                height={67}
                className="w-auto max-h-16 object-contain"
              />
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}