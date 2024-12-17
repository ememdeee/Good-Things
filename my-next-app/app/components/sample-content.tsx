'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { FileText, Car } from 'lucide-react'
import Image from 'next/image'
import { CTASection } from './CTASection'
import Link from 'next/link'

export function SampleContent() {
  const [activeTab, setActiveTab] = useState('report')

  return (
    <div className="min-h-screen">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            Sample Reports
          </Badge>
          <h1 className="text-4xl font-bold mb-4">
            View Sample Vehicle History Report and Window Sticker
          </h1>
          <p className="text-lg text-gray-600">
            Explore our comprehensive reports before making a purchase. See exactly what you&apos;ll receive.
          </p>
        </div>

        <Tabs defaultValue={activeTab} onValueChange={setActiveTab} className="max-w-4xl mx-auto">
          <TabsList className="grid w-full grid-cols-2">
            <TabsTrigger value="report">Vehicle History Report</TabsTrigger>
            <TabsTrigger value="sticker">Window Sticker</TabsTrigger>
          </TabsList>
          <TabsContent value="report">
            <Card>
              <CardHeader>
                <CardTitle>Sample Vehicle History Report</CardTitle>
                <CardDescription>
                  Our detailed report provides a comprehensive overview of the vehicle&apos;s history.
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
              <div className="relative bg-gray-100 rounded-lg overflow-hidden">
                <Image
                  src="/sample-report.png"
                  alt="Sample Vehicle History Report"
                  width={1600}
                  height={900}
                  style={{ width: '100%', height: 'auto' }}
                />
              </div>
                <div className="grid gap-4 md:grid-cols-2">
                  <div>
                    <h3 className="font-semibold mb-2">Report Highlights:</h3>
                    <ul className="list-disc list-inside space-y-1 text-sm text-gray-600">
                      <li>Accident history</li>
                      <li>Service records</li>
                      <li>Ownership details</li>
                      <li>Title information</li>
                      <li>Mileage verification</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold mb-2">Why Our Report?</h3>
                    <ul className="list-disc list-inside space-y-1 text-sm text-gray-600">
                      <li>Data from multiple sources</li>
                      <li>Easy-to-read format</li>
                      <li>Detailed analysis</li>
                      <li>Buyback guarantee</li>
                    </ul>
                  </div>
                </div>
                <div className="flex justify-center space-x-4">
                  <Link href={"/report/vin/2T1BURHE0FC320645"}>
                    <Button>
                      <FileText className="mr-2 h-4 w-4" />
                      View Full Sample Report
                    </Button>
                  </Link>
                  <Link href={"/"}>
                    <Button variant="outline">
                      Get Your Vehicle&apos;s Report
                    </Button>
                  </Link>
                </div>
              </CardContent>
            </Card>
          </TabsContent>
          <TabsContent value="sticker">
            <Card>
              <CardHeader>
                <CardTitle>Sample Window Sticker</CardTitle>
                <CardDescription>
                  View a sample of our detailed window sticker, showcasing all the original vehicle information.
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
              <div className="relative rounded-lg overflow-hidden">
                <Image
                  src="/Sticker-WAUFFAFC5HN007408.png"
                  alt="Sample Window Sticker"
                  width={800}
                  height={1000}
                  style={{ width: '100%', height: 'auto' }}
                />
              </div>
                <div className="grid gap-4 md:grid-cols-2">
                  <div>
                    <h3 className="font-semibold mb-2">Sticker Information:</h3>
                    <ul className="list-disc list-inside space-y-1 text-sm text-gray-600">
                      <li>Vehicle specifications</li>
                      <li>Standard features</li>
                      <li>Optional equipment</li>
                      <li>Pricing details</li>
                      <li>Fuel economy ratings</li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold mb-2">Benefits:</h3>
                    <ul className="list-disc list-inside space-y-1 text-sm text-gray-600">
                      <li>Verify original equipment</li>
                      <li>Understand vehicle value</li>
                      <li>Compare features accurately</li>
                      <li>Ensure authenticity</li>
                    </ul>
                  </div>
                </div>
                <div className="flex justify-center space-x-4">
                  <Link href={"/sticker/vin/WAUFFAFC5HN007408-E323E323-C5C5-4A45-31B5-C95F9EB7CBEC"}>
                    <Button>
                      <Car className="mr-2 h-4 w-4" />
                      View Full Sample Sticker
                    </Button>
                  </Link>
                  <Link href={"/window-sticker"}>
                    <Button variant="outline">
                      Get Your Vehicle&apos;s Sticker
                    </Button>
                  </Link>
                </div>
              </CardContent>
            </Card>
          </TabsContent>
        </Tabs>

        <CTASection
          title="Ready to Get Your Full Report?"
          description="Access comprehensive vehicle history and original window stickers with just a few clicks."
          buttonText="Get Vehicle History"
          buttonLink="/"
        />

        <div className="mt-16 bg-white rounded-xl p-8 shadow-lg">
          <h2 className="text-2xl font-bold mb-4 text-center">Frequently Asked Questions</h2>
          <div className="grid gap-6 md:grid-cols-2">
            {[
              {
                q: "How accurate is the vehicle history report?",
                a: "Our reports are highly accurate, compiled from various reliable sources including government databases, insurance records, and service histories."
              },
              {
                q: "Can I get a window sticker for an older vehicle?",
                a: "Yes, we can provide window stickers for most vehicles, including older models. The information available may vary based on the vehicle's age."
              },
              {
                q: "What if I find an error in my report?",
                a: "We stand behind our reports. If you find any inaccuracies, please contact our customer support, and we'll investigate and correct any errors promptly."
              },
              {
                q: "How often are your reports updated?",
                a: "Our database is updated regularly to ensure you receive the most current information available about your vehicle."
              }
            ].map((faq, index) => (
              <div key={index}>
                <h3 className="font-semibold mb-2">{faq.q}</h3>
                <p className="text-sm text-gray-600">{faq.a}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  )
}

