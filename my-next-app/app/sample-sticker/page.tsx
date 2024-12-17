import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import Image from 'next/image'
import Link from 'next/link'
import { CTASection } from '../components/CTASection'

const vehicleTypes = [
  {
    type: "Car",
    samples: [
      { 
        title: "2017 Audi S6", 
        date: "0999/2023", 
        vin: "WAUFFAFC5HN007408",
        imageUrl: "/Sticker-WAUFFAFC5HN007408.png",
        sampleUrl: "/sticker/vin/WAUFFAFC5HN007408-E323E323-C5C5-4A45-31B5-C95F9EB7CBEC"
      },
      { 
        title: "Ford 2020 F-150", 
        date: "02228/2023", 
        vin: "1FTFW1RG6LFA12962",
        imageUrl: "/Sticker-1FTFW1RG6LFA12962.png",
        sampleUrl: "/sticker/vin/1FTFW1RG6LFA12962-A839A839-4848-4C2A-64E7-90517C0A1DC1"
      },
      { 
        title: "2022 Mercedes-Benz A Class", 
        date: "07/2023", 
        vin: "W1N4N4HB1NJ342468",
        imageUrl: "Sticker-W1N4N4HB1NJ342468.png",
        sampleUrl: "/sticker/vin/W1N4N4HB1NJ342468-8F748F74-6D6D-2406-1E54-BD17CA2AD529"
      }
    ]
  },
  {
    type: "Truck",
    samples: [
      { 
        title: "2023 Ford F-150", 
        date: "09/2023", 
        vin: "1FTFW1E86NFA00001",
        imageUrl: "/Cars.png",
        sampleUrl: "/sample-sticker"
      },
      { 
        title: "2022 Chevrolet Silverado", 
        date: "08/2023", 
        vin: "3GCPYFED6NG000001",
        imageUrl: "/Cars.png",
        sampleUrl: "/sample-sticker"
      }
    ]
  },
  {
    type: "SUV",
    samples: [
      { 
        title: "2023 Toyota RAV4", 
        date: "09/2023", 
        vin: "2T3F1RFV0PW000001",
        imageUrl: "/Cars.png",
        sampleUrl: "/sample-sticker"
      },
      { 
        title: "2022 Honda CR-V", 
        date: "08/2023", 
        vin: "7FARW2H90NE000001",
        imageUrl: "/Cars.png",
        sampleUrl: "/sample-sticker"
      }
    ]
  }
]

export default function SampleStickerPage() {
  return (
    <div className="min-h-screen">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <h1 className="text-4xl font-bold mb-4 ">
            Sample Window Stickers
          </h1>
          <p className="text-lg text-gray-600">
            Explore our comprehensive window stickers. See exactly what you&apos;ll receive before making a purchase.
          </p>
        </div>

        <div className="flex justify-center gap-4 mb-12">
          <Link href={'#window-sticker-sample'}>
            <Button className="">
              View Window Sticker
            </Button>
          </Link>
          <Link href={'/sample'}>
            <Button variant="outline" className="hover:bg-blue-50 transition-all duration-300">
              View History Report
            </Button>
          </Link>
        </div>

        <div id='window-sticker-sample' className="flex flex-col space-y-12 scroll-mt-16">
          {vehicleTypes.map((category) => (
            <div key={category.type} className="w-full">
              <h2 className="text-2xl font-semibold text-gray-800 mb-6">
                {category.type} Window Stickers
              </h2>
              <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {category.samples.map((sample) => (
                  <Card key={sample.title} className="group hover:shadow-lg transition-all duration-300">
                    <CardContent className="p-4 space-y-4">
                      <div className="relative bg-gray-100 rounded-lg overflow-hidden">
                        <Image
                          src={sample.imageUrl}
                          alt={`${sample.title} Window Sticker Preview`}
                          width={800}
                          height={1000}
                          style={{ width: '100%', height: 'auto' }}
                          className="object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                      </div>
                      <div className="space-y-2">
                        <h3 className="font-semibold group-hover:text-blue-600 transition-colors duration-300">
                          {sample.title}
                        </h3>
                        <div className="text-sm text-gray-500">
                          <p>Sticker Date: {sample.date}</p>
                          <p className="truncate">VIN: {sample.vin}</p>
                        </div>
                        <Link href={sample.sampleUrl}>
                          <Button 
                            variant="ghost" 
                            className="w-full hover:bg-blue-50 transition-colors duration-300"
                          >
                            View Sample
                          </Button>
                        </Link>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>
          ))}
        </div>

        <CTASection
          title="Ready to Get Your Window Sticker?"
          description="Access comprehensive window stickers instantly"
          buttonText="Get Started Now"
          buttonLink="/window-sticker"
        />
      </div>
    </div>
  )
}

