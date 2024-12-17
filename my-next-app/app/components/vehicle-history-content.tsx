import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Shield, AlertTriangle, Clock, DollarSign } from 'lucide-react'
import Image from 'next/image'

export function VehicleHistoryContent() {
  return (
    <>
      <section className="bg-gradient-to-b from-white to-gray-50 py-12 md:py-24">
        <div className="container px-4">
          <div className="grid gap-12 lg:grid-cols-2">
            <div className="flex flex-col justify-center space-y-8">
              <div className="space-y-4">
                <h1 className="text-4xl font-bold tracking-tighter sm:text-5xl">
                  Comprehensive Vehicle History Reports
                </h1>
                <p className="text-xl text-gray-500">
                  Get detailed insights into any vehicle&apos;s past, including accidents, service records, ownership history, and more.
                </p>
              </div>
              <div className="flex flex-col gap-4 sm:flex-row">
                <Button size="lg" className="w-full sm:w-auto">
                  Check Vehicle History
                </Button>
                <Button variant="outline" size="lg" className="w-full sm:w-auto">
                  View Sample Report
                </Button>
              </div>
            </div>
            <div className="relative">
              <Image
                src="/placeholder.svg"
                alt="Vehicle History Report"
                width={600}
                height={400}
                className="rounded-lg shadow-xl"
              />
            </div>
          </div>
        </div>
      </section>

      <section className="py-20">
        <div className="container px-4">
          <div className="text-center">
            <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl">
              What&apos;s Included in Your Report
            </h2>
            <p className="mx-auto mt-4 max-w-[700px] text-gray-500 md:text-xl">
              Our comprehensive reports check 70+ databases to give you the full picture
            </p>
          </div>
          <div className="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            <Card>
              <CardContent className="pt-6">
                <AlertTriangle className="h-12 w-12 text-blue-600" />
                <h3 className="mt-4 font-bold">Accident History</h3>
                <p className="mt-2 text-sm text-gray-500">
                  Detailed accident reports and damage records
                </p>
              </CardContent>
            </Card>
            <Card>
              <CardContent className="pt-6">
                <Clock className="h-12 w-12 text-blue-600" />
                <h3 className="mt-4 font-bold">Service Records</h3>
                <p className="mt-2 text-sm text-gray-500">
                  Maintenance history and service intervals
                </p>
              </CardContent>
            </Card>
            <Card>
              <CardContent className="pt-6">
                <Shield className="h-12 w-12 text-blue-600" />
                <h3 className="mt-4 font-bold">Title Information</h3>
                <p className="mt-2 text-sm text-gray-500">
                  Title status, transfers, and brandings
                </p>
              </CardContent>
            </Card>
            <Card>
              <CardContent className="pt-6">
                <DollarSign className="h-12 w-12 text-blue-600" />
                <h3 className="mt-4 font-bold">Market Value</h3>
                <p className="mt-2 text-sm text-gray-500">
                  Current market value based on condition
                </p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      <section className="border-t bg-gray-50 py-20">
        <div className="container px-4">
          <div className="grid gap-12 lg:grid-cols-2">
            <div className="flex flex-col justify-center space-y-8">
              <div className="space-y-4">
                <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl">
                  Why Choose Our Reports
                </h2>
                <div className="space-y-4">
                  <div className="flex items-start space-x-4">
                    <Shield className="h-6 w-6 text-blue-600" />
                    <div>
                      <h3 className="font-bold">Most Comprehensive Data</h3>
                      <p className="text-gray-500">
                        We check more sources than any other provider
                      </p>
                    </div>
                  </div>
                  <div className="flex items-start space-x-4">
                    <Clock className="h-6 w-6 text-blue-600" />
                    <div>
                      <h3 className="font-bold">Real-Time Updates</h3>
                      <p className="text-gray-500">
                        Our reports are updated in real-time
                      </p>
                    </div>
                  </div>
                  <div className="flex items-start space-x-4">
                    <DollarSign className="h-6 w-6 text-blue-600" />
                    <div>
                      <h3 className="font-bold">Best Value</h3>
                      <p className="text-gray-500">
                        More information at a better price
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="relative">
              <Image
                src="/placeholder.svg"
                alt="Report Features"
                width={600}
                height={400}
                className="rounded-lg"
              />
            </div>
          </div>
        </div>
      </section>
    </>
  )
}

