import Image from 'next/image'
import SiteForm from './SiteForm'

export function Hero() {

  return (
    <section className="relative overflow-hidden bg-gray-50 py-12 md:py-20">
      <div className="container mx-auto px-4">
        <div className="grid gap-12 lg:grid-cols-2 lg:gap-8">
          <div className="flex flex-col justify-center space-y-8">
            <div className="space-y-4">
              <h1 className="text-4xl font-bold tracking-tighter sm:text-5xl">
                Maximize Your Car&apos;s Value with Complete History & Original Window Sticker
              </h1>
              <p className="text-xl text-gray-600">
                Get instant access to your vehicle&apos;s complete history and authentic window sticker. 
                Perfect for sellers looking to build trust and get top dollar.
              </p>
            </div>
            <div className="space-y-4">
              <SiteForm />
            </div>
          </div>
          <div className="flex items-center justify-center lg:justify-end">
            <div className="relative w-full max-w-[500px] aspect-square">
              <Image
                src="/Home Page Hero Section.png"
                alt="Luxury Car"
                fill
                style={{ objectFit: 'contain' }}
                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}