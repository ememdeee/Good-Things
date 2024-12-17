import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs'
import Image from 'next/image'
import Link from 'next/link'

const vehicleTypes = [
  {
    type: "Car",
    samples: [
      { title: "2023 Tesla Model S", date: "09/2023", vin: "5YJSA1E29PF000001" },
      { title: "2022 BMW M3", date: "08/2023", vin: "WBS43AZ04NCH11111" },
      { title: "2021 Mercedes-Benz C300", date: "07/2023", vin: "WDDWF8EB1HR000001" },
      { title: "2020 Audi Q7", date: "06/2023", vin: "WA1VABF70KD000001" }
    ]
  },
  {
    type: "Truck",
    samples: [
      { title: "2023 Ford F-150", date: "09/2023", vin: "1FTFW1E86NFA00001" },
      { title: "2022 Chevrolet Silverado", date: "08/2023", vin: "3GCPYFED6NG000001" }
    ]
  },
  {
    type: "SUV",
    samples: [
      { title: "2023 Toyota RAV4", date: "09/2023", vin: "2T3F1RFV0PW000001" },
      { title: "2022 Honda CR-V", date: "08/2023", vin: "7FARW2H90NE000001" }
    ]
  }
]

const carBrands = [
  'Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes-Benz', 'Audi', 
  'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai', 'Kia', 'Lexus'
]

export default function SampleStickerPage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-100 via-white to-purple-100">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <h1 className="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            Sample Window Stickers
          </h1>
          <p className="text-lg text-gray-600">
            Explore our comprehensive window stickers. See exactly what you'll receive before making a purchase.
          </p>
        </div>

        <div className="flex justify-center gap-4 mb-12">
          <Button className="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
            View Window Sticker
          </Button>
          <Button variant="outline" className="hover:bg-blue-50 transition-all duration-300">
            View History Report
          </Button>
        </div>

        <div className="flex flex-col space-y-12">
          {vehicleTypes.map((category) => (
            <div key={category.type} className="w-full">
              <h2 className="text-2xl font-semibold text-gray-800 mb-6">
                {category.type} Window Stickers
              </h2>
              <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {category.samples.map((sample) => (
                  <Card key={sample.title} className="group hover:shadow-lg transition-all duration-300">
                    <CardContent className="p-4 space-y-4">
                      <div className="aspect-[4/5] relative bg-gray-100 rounded-lg overflow-hidden">
                        <Image
                          src="/placeholder.svg"
                          alt={`${sample.title} Window Sticker Preview`}
                          fill
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
                        <Button 
                          variant="ghost" 
                          className="w-full hover:bg-blue-50 transition-colors duration-300"
                        >
                          View Sample
                        </Button>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>
          ))}
        </div>

        <div className="mt-16 text-center">
          <h2 className="text-2xl font-semibold mb-6">Looking for a Specific Make?</h2>
          <div className="max-w-4xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            {carBrands.map((brand) => (
              <Link
                key={brand}
                href="#"
                className="px-4 py-2 bg-white rounded-lg hover:bg-blue-50 transition-colors duration-300 text-sm text-gray-600 hover:text-blue-600 whitespace-nowrap overflow-hidden text-ellipsis"
              >
                {brand}
              </Link>
            ))}
          </div>
        </div>

        <div className="mt-16 text-center bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl p-8">
          <h2 className="text-2xl font-semibold mb-4">
            Ready to Get Your Window Sticker?
          </h2>
          <p className="mb-6 text-blue-50">
            Access comprehensive window stickers instantly
          </p>
          <Button size="lg" variant="secondary" className="hover:bg-white transition-all duration-300">
            Get Started Now
          </Button>
        </div>
      </div>
    </div>
  )
}

