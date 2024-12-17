'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { FileText, Zap, ShieldCheck, BarChart2, ChevronLeft, ChevronRight } from 'lucide-react'
import Image from 'next/image'

const stickerFeatures = [
  {
    icon: FileText,
    title: "Comprehensive Details",
    description: "Full list of features, options, and specifications.",
    color: "text-blue-500"
  },
  {
    icon: Zap,
    title: "Performance Insights",
    description: "Engine specs, fuel economy, and more.",
    color: "text-yellow-500"
  },
  {
    icon: ShieldCheck,
    title: "Build Trust",
    description: "Transparency that buyers appreciate and trust.",
    color: "text-green-500"
  },
  {
    icon: BarChart2,
    title: "Value Justification",
    description: "Helps justify your asking price with facts.",
    color: "text-purple-500"
  }
]

export function WindowStickerSection() {
  const [activeFeature, setActiveFeature] = useState(0)

  const nextFeature = () => {
    setActiveFeature((prev) => (prev + 1) % stickerFeatures.length)
  }

  const prevFeature = () => {
    setActiveFeature((prev) => (prev - 1 + stickerFeatures.length) % stickerFeatures.length)
  }

  return (
    <section className="py-16 bg-gradient-to-b from-white to-gray-50">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold tracking-tight text-center sm:text-4xl md:text-5xl mb-12 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
          Window Stickers: Empowering Buyers with Insights
        </h2>
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="space-y-6">
            <p className="text-xl text-gray-600">
              A window sticker is more than just a label—it's a gateway to everything buyers need to know about your car. From features and options to performance details and history, it provides a clear, comprehensive snapshot that builds confidence and streamlines the buying process.
            </p>
            <div className="relative h-[400px] bg-gray-100 rounded-lg overflow-hidden">
              <Image
                src="/placeholder.svg"
                alt="Interactive Window Sticker"
                layout="fill"
                objectFit="cover"
              />
              <div className="absolute inset-0 bg-gradient-to-r from-white/80 to-transparent flex items-center">
                <div className="p-6 max-w-md">
                  <h3 className="text-2xl font-bold mb-4">Explore the Sticker</h3>
                  <p className="text-gray-700 mb-4">Click through to discover how a window sticker provides crucial information to potential buyers.</p>
                  <div className="flex items-center space-x-4">
                    <Button onClick={prevFeature} variant="outline" size="icon">
                      <ChevronLeft className="h-4 w-4" />
                    </Button>
                    <Button onClick={nextFeature} variant="outline" size="icon">
                      <ChevronRight className="h-4 w-4" />
                    </Button>
                  </div>
                </div>
              </div>
              <div className="absolute bottom-0 left-0 right-0 bg-white/80 p-4">
                <p className="text-sm font-medium text-gray-900">
                  {stickerFeatures[activeFeature].title}
                </p>
              </div>
            </div>
          </div>
          <div className="space-y-6">
            <h3 className="text-2xl font-bold">Key Benefits of Window Stickers</h3>
            <div className="grid gap-6">
              {stickerFeatures.map((feature, index) => (
                <Card key={index} className={`transition-all duration-300 ${index === activeFeature ? 'scale-105 shadow-lg' : 'opacity-70'}`}>
                  <CardContent className="p-6 flex items-start space-x-4">
                    <feature.icon className={`h-8 w-8 ${feature.color}`} />
                    <div>
                      <h4 className="font-semibold mb-2">{feature.title}</h4>
                      <p className="text-sm text-gray-600">{feature.description}</p>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
            <div className="text-center">
              <Button size="lg" className="mt-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
                Get Your Window Sticker
              </Button>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

