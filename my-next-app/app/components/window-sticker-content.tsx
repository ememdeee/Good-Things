'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Star, Download, Search, Calendar, FileText, Palette, List, DollarSign, Play, Eye, TrendingUp, ShieldCheck, Zap } from 'lucide-react'
import Image from 'next/image'
import Link from 'next/link'
import { CTASection } from './CTASection'
import { VehicleCategories } from '../window-sticker/VehicleCategories'
import { BenefitsStatistics } from '../window-sticker/BenefitsStatistics'
import { ManufacturerDirectory } from './ManufacturerDirectory'
import SiteForm from './SiteForm'

export function WindowStickerContent() {
  const [activeTab, setActiveTab] = useState('vin')

  return (
    <div className="min-h-screen">
      <div className="container mx-auto px-4 py-12">
        {/* Hero Section */}
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            Trusted by over 1,000,000 users
          </Badge>
          <h1 className="text-4xl font-bold mb-4">
            Window Sticker Lookup by VIN
          </h1>
          <p className="text-lg text-gray-600">
            Fast & Easy, Use your VIN to search now
          </p>
        </div>

        {/* Search Section */}
        <div className="max-w-2xl mx-auto mb-12">
          <SiteForm reportType='WS' />
        </div>

        {/* Trust Indicators */}
        <div className="flex flex-wrap justify-center items-center gap-8 mb-16">
          <div className="flex items-center space-x-2">
            <div className="flex">
              {[1, 2, 3, 4, 5].map((star) => (
                <Star key={star} className="w-5 h-5 text-yellow-400 fill-current" />
              ))}
            </div>
            <span className="font-semibold">4.8/5</span>
            <span className="text-gray-600">(600+ Reviews)</span>
          </div>
          <div className="flex gap-4">
            {['Forbes', 'Reuters', 'TopGear'].map((brand) => (
              <div key={brand} className="text-gray-400 font-semibold">
                {brand}
              </div>
            ))}
          </div>
        </div>

        {/* Vehicle Categories Section */}
        <VehicleCategories />

        {/* What is a Window Sticker Section */}
        <div className="grid lg:grid-cols-2 gap-12 items-center mb-16">
          <div className="space-y-6 text-center md:text-left">
            <h2 className="text-3xl font-bold">
              What is a Window Sticker?
            </h2>
            <p className="text-lg text-gray-600">
              A window sticker (also known as a Monroney label) is mandated for display on all new cars in the U.S. It provides essential information about the car, including:
            </p>
            <ul className="space-y-4">
              {[
                { icon: FileText, text: "Vehicle specifications and features" },
                { icon: Download, text: "Original MSRP and pricing details" },
                { icon: Search, text: "Safety ratings and fuel economy" },
                { icon: Calendar, text: "Manufacturing information" },
              ].map((item, index) => (
                <li key={index} className="flex items-center space-x-3">
                  <item.icon className="w-5 h-5 text-blue-600" />
                  <span className="text-gray-600">{item.text}</span>
                </li>
              ))}
            </ul>
          </div>
          <div className="relative flex justify-center">
            <Image
              src="/Unlock the Secrets of Your Window Sticker.png"
              alt="Sample Window Sticker"
              width={600}
              height={800}
            />
          </div>
        </div>

        {/* How to Read a Window Sticker Section */}
        <section className="py-16">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12">
              Unlock the Secrets of Your Window Sticker
            </h2>
            <div className="grid md:grid-cols-2 gap-8 items-center">
              <div className="space-y-6">
                <p className="text-lg text-gray-600">
                  Your window sticker is a treasure trove of information. Learn how to decode it and gain valuable insights about your vehicle!
                </p>
                <div className="grid gap-4">
                  {[
                    { icon: Eye, title: "Vehicle Details", description: "Uncover make, model, year, and VIN" },
                    { icon: Palette, title: "Color & Style", description: "Explore exterior and interior options" },
                    { icon: List, title: "Features & Equipment", description: "Discover standard and optional features" },
                    { icon: DollarSign, title: "Pricing Breakdown", description: "Understand MSRP and additional costs" },
                    { icon: Zap, title: "Performance Specs", description: "Learn about engine, transmission, and fuel economy" },
                  ].map((item, index) => (
                    <div key={index} className="flex items-start space-x-3">
                      <item.icon className="w-6 h-6 text-blue-600 mt-1" />
                      <div>
                        <h3 className="font-semibold text-lg">{item.title}</h3>
                        <p className="text-gray-600">{item.description}</p>
                      </div>
                    </div>
                  ))}
                </div>
                <Button className="bg-blue-600 hover:bg-blue-700 text-white">
                  Get Your Window Sticker Now
                </Button>
              </div>
              <div className="relative flex justify-center">
                <Image
                  src="/Unlock the Secrets of Your Window Sticker.png"
                  alt="Window Sticker Diagram"
                  width={600}
                  height={800}
                />
              </div>
            </div>
          </div>
        </section>

        {/* Why Window Stickers Matter Section */}
        <section className="py-16">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12">
              Why Window Stickers Are Your Secret Weapon
            </h2>
            <div className="grid md:grid-cols-3 gap-8">
              {[
                {
                  icon: TrendingUp,
                  title: "Boost Your Selling Power",
                  description: "Showcase your vehicle's true value and stand out in the market. Window stickers help you command top dollar for your ride."
                },
                {
                  icon: ShieldCheck,
                  title: "Build Instant Trust",
                  description: "Transparency is key in any transaction. Window stickers provide verified information, creating confidence in potential buyers."
                },
                {
                  icon: Zap,
                  title: "Streamline Your Sale",
                  description: "Armed with all the details, buyers can make faster decisions. Reduce back-and-forth and close deals more efficiently."
                }
              ].map((card, index) => (
                <Card key={index} className="transition-all duration-300 hover:shadow-lg">
                  <CardHeader>
                    <card.icon className="w-12 h-12 text-blue-600 mb-4" />
                    <CardTitle>{card.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                    <p className="text-gray-600">{card.description}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
            <div className="text-center mt-12">
              <Button size="lg">
                Unlock Your Vehicle&apos;s Potential
              </Button>
            </div>
          </div>
        </section>

        {/* Breakdown of an Original Window Sticker Section */}
        <section className="py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center mb-8">
            Decode Your Window Sticker
          </h2>
          <div className="grid grid-cols-1 gap-8 items-center">
            <div className="relative aspect-video bg-gray-200 rounded-lg overflow-hidden max-w-3xl mx-auto w-full">
              <Image
                src="/Cars.png"
                alt="Cars background"
                layout="fill"
                objectFit="cover"
                className="rounded-lg"
              />
              <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40">
                <Link 
                  href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" 
                  target="_blank" 
                  rel="noopener noreferrer"
                >
                  <Button 
                    variant="secondary"
                    size="lg"
                    className="bg-white text-blue-600 hover:bg-blue-50"
                  >
                    <Play className="mr-2 h-4 w-4" />
                    Watch Guide
                  </Button>
                </Link>
              </div>
            </div>
            <div className="space-y-6 max-w-3xl mx-auto w-full">
              {[
                { 
                  title: "Vehicle Identification", 
                  description: "Includes crucial details such as the year, make, model, and unique VIN number." 
                },
                { 
                  title: "Aesthetics", 
                  description: "Specifies both interior and exterior colors, catering to buyers' style preferences." 
                },
                { 
                  title: "Features & Warranties", 
                  description: "Comprehensive list of standard equipment, from exterior and interior features to mechanical specifications and safety measures." 
                },
                { 
                  title: "Pricing Breakdown", 
                  description: "Detailed cost information including MSRP, total price with add-ons, and shipping charges." 
                },
                { 
                  title: "Optional Extras", 
                  description: "Highlights additional features and packages available beyond standard offerings." 
                },
                { 
                  title: "Efficiency & Safety", 
                  description: "Displays EPA fuel economy ratings and NHTSA safety scores, aiding in informed decision-making." 
                }
              ].map((item, index) => (
                <div key={index} className="group cursor-pointer transition-all duration-300 hover:bg-white hover:shadow-md rounded-lg p-4">
                  <h3 className="text-lg font-semibold mb-2 group-hover:text-blue-600 transition-colors">
                    {item.title}
                  </h3>
                  <p className="text-gray-600 group-hover:text-gray-800 transition-colors">
                    {item.description}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

        {/* Benefits Statistics Section */}
        <BenefitsStatistics/>

        {/* Classic Car Build Sheet Section */}
        <section className="py-12">
          <div className="container mx-auto px-4">
            <div className="flex flex-col md:flex-row items-center justify-between gap-8">
              <div className="md:w-1/2 text-center md:text-left">
                <h2 className="text-3xl font-bold mb-4">
                  Classic Car Build Sheets
                </h2>
                <p className="text-lg text-gray-600 mb-6">
                  Unlock your classic car&apos;s heritage with authentic build sheets. Verify specs and features for restoration or collection.
                </p>
                <Link href={'/sample-sticker'}>
                  <Button 
                    className="bg-blue-600 hover:bg-blue-700 text-white"
                    size="lg"
                  >
                    View Sample Build Sheet
                  </Button>
                </Link>
              </div>
              <div className="md:w-1/2 relative group">
                <Image
                  src="/Classic Car Build Sheets.png"
                  alt="Classic Car Build Sheet"
                  width={500}
                  height={300}
                  className="rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-[1.02]"
                />
              </div>
            </div>
            <div className="grid md:grid-cols-3 gap-6 mt-8">
              {[
                { title: "Authentic Details", description: "Access original specs and options" },
                { title: "Verify History", description: "Confirm authenticity with factory docs" },
                { title: "Restoration Guide", description: "Get precise details for accurate restoration" }
              ].map((feature, index) => (
                <div key={index} className="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                  <h3 className="text-lg font-semibold mb-2">{feature.title}</h3>
                  <p className="text-sm text-gray-600">{feature.description}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Manufacturer Directory Section */}
        <ManufacturerDirectory />

        {/* Dealer Solutions Section */}
        <section className="py-16">
          <div className="container mx-auto px-4">
            <h2 className="text-4xl font-bold text-center mb-8">
              Professional Window Sticker Solutions for Dealerships
            </h2>
            <div className="max-w-3xl mx-auto text-center mb-12">
              <p className="text-lg text-gray-600 mb-6">
                Enhance your dealership&apos;s professional image while ensuring compliance with our comprehensive window sticker solutions. Our customizable options help boost sales and streamline trade-in evaluations.
              </p>
              <p className="text-lg text-gray-600">
                We&apos;ve developed flexible window sticker solutions that cater to the unique needs of automotive dealerships, offering both standardized and custom options to match your specific business requirements.
              </p>
            </div>
            <div className="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
              <div className="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h3 className="text-2xl font-bold mb-4">Standard Edition</h3>
                <p className="text-gray-600 mb-6">
                  Elevate your dealership with our professional branded window stickers. Featuring your dealership&apos;s identity alongside comprehensive vehicle details, our solution helps increase ROI and streamline sales processes with our intuitive window sticker platform.
                </p>
                <Button>
                  Explore Standard Options
                </Button>
              </div>
              <div className="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h3 className="text-2xl font-bold mb-4">Custom Edition</h3>
                <p className="text-gray-600 mb-6">
                  Create fully personalized window stickers that perfectly match your brand. Incorporate your logo, business information, operating hours, location details, and more to transform every window sticker into a powerful marketing asset.
                </p>
                <Button variant="outline">
                  Request Custom Solution
                </Button>
              </div>
            </div>
            <div className="flex justify-center items-center gap-4 mt-12">
              <Button variant="outline" size="lg" className="hover:bg-blue-50">
                Schedule Consultation
              </Button>
              <Button variant="link" size="lg" className="text-blue-600 hover:text-blue-700">
                Watch Demo
              </Button>
            </div>
          </div>
        </section>

        <CTASection
          title="Ready to Unlock Your Vehicle's Full Story?"
          description="Get your original window sticker now and take control of your car's narrative"
          buttonText="Get Your Window Sticker"
          buttonLink="/get-window-sticker"
        />
      </div>
    </div>
  )
}

