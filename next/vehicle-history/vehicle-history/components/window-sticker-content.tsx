'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Star, Download, Search, Calendar, FileText, Palette, List, DollarSign, ChevronLeft, ChevronRight, Play, Eye, TrendingUp, ShieldCheck, Zap, CheckCircle, AlertTriangle, Clock, Car } from 'lucide-react'
import Image from 'next/image'
import Link from 'next/link'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"

export function WindowStickerContent() {
  const [activeTab, setActiveTab] = useState('vin')

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-100 via-white to-purple-100">
      <div className="container mx-auto px-4 py-12">
        {/* Hero Section */}
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            Trusted by over 1,000,000 users
          </Badge>
          <h1 className="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            Window Sticker Lookup by VIN
          </h1>
          <p className="text-lg text-gray-600">
            Fast & Easy, Use your VIN to search now
          </p>
        </div>

        {/* Search Section */}
        <Card className="max-w-2xl mx-auto mb-12">
          <CardContent className="p-6">
            <Tabs defaultValue="vin" className="w-full" onValueChange={setActiveTab}>
              <TabsList className="grid w-full grid-cols-3 mb-6">
                <TabsTrigger value="vin">By VIN</TabsTrigger>
                <TabsTrigger value="plate">By US License Plate</TabsTrigger>
                <TabsTrigger value="year">Year | Make | Model</TabsTrigger>
              </TabsList>
              <div className="space-y-4">
                {activeTab === 'vin' && (
                  <Input placeholder="Enter VIN Number" className="text-lg" />
                )}
                {activeTab === 'plate' && (
                  <div className="grid grid-cols-2 gap-4">
                    <Input placeholder="License Plate" className="text-lg" />
                    <Input placeholder="State" className="text-lg" />
                  </div>
                )}
                {activeTab === 'year' && (
                  <div className="grid grid-cols-3 gap-4">
                    <Input placeholder="Year" className="text-lg" />
                    <Input placeholder="Make" className="text-lg" />
                    <Input placeholder="Model" className="text-lg" />
                  </div>
                )}
                <div className="grid grid-cols-2 gap-4">
                  <Input type="email" placeholder="Email Address" />
                  <Input type="tel" placeholder="Phone (Optional)" />
                </div>
                <Button className="w-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
                  Search Window Sticker
                </Button>
                <div className="flex justify-between text-sm text-gray-500 mt-2">
                  <Link href="#" className="hover:text-blue-600">
                    Where can I find the VIN?
                  </Link>
                  <Link href="#" className="hover:text-blue-600">
                    No VIN? Continue without VIN
                  </Link>
                </div>
              </div>
            </Tabs>
          </CardContent>
        </Card>

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
        <div className="mb-16">
          <h2 className="text-4xl font-bold text-center mb-8">
            Find Window Stickers for all types of vehicles
          </h2>
          <div className="flex flex-wrap justify-center gap-4">
            {[
              "Cars",
              "SUVs and Pickups",
              "Electric vehicles",
              "Classic cars",
              "Trucks",
              "Motorcycles"
            ].map((category, index) => (
              <Button
                key={index}
                variant={category === "Trucks" ? "default" : "outline"}
                className={`min-w-[140px] ${category === "Trucks" ? "bg-blue-100 hover:bg-blue-200 text-blue-800" : ""}`}
              >
                {category}
              </Button>
            ))}
          </div>
          <div className="mt-8 max-w-4xl mx-auto">
            <Image
              src="/placeholder.svg"
              alt="Sample Window Sticker"
              width={800}
              height={600}
              className="w-full rounded-lg shadow-lg"
            />
            <div className="mt-4 text-center">
              <Button variant="primary" size="lg" className="bg-blue-600 hover:bg-blue-700 text-white">
                View window sticker
              </Button>
            </div>
          </div>
        </div>

        {/* What is a Window Sticker Section */}
        <div className="grid lg:grid-cols-2 gap-12 items-center mb-16">
          <div className="space-y-6 text-center md:text-left">
            <h2 className="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
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
          <div className="relative">
            <Image
              src="/placeholder.svg"
              alt="Sample Window Sticker"
              width={600}
              height={800}
              className="rounded-lg shadow-xl"
            />
            <Button 
              variant="secondary"
              className="absolute bottom-4 right-4 bg-white/90 hover:bg-white"
            >
              View Sample
            </Button>
          </div>
        </div>

        {/* How to Read a Window Sticker Section */}
        <section className="py-16 bg-gradient-to-br from-white to-gray-50">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
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
              <div className="relative">
                <Image
                  src="/placeholder.svg"
                  alt="Window Sticker Diagram"
                  width={600}
                  height={800}
                  className="rounded-lg shadow-xl"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg" />
                <div className="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <p className="text-sm font-semibold">Interactive Window Sticker Guide</p>
                  <p className="text-xs">Hover over sections to learn more</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* Why Window Stickers Matter Section */}
        <section className="py-16 bg-white">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
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
              <Button size="lg" className="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-300">
                Unlock Your Vehicle's Potential
              </Button>
            </div>
          </div>
        </section>

        {/* Breakdown of an Original Window Sticker Section */}
        <section className="py-16 bg-gradient-to-br from-white to-gray-50">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-8 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
              Decode Your Window Sticker
            </h2>
            <div className="grid grid-cols-1 gap-8 items-center">
              <div className="relative aspect-video bg-gray-200 rounded-lg overflow-hidden max-w-3xl mx-auto w-full">
                <div className="absolute inset-0 flex items-center justify-center">
                  <Button 
                    variant="secondary"
                    size="lg"
                    className="bg-white text-blue-600 hover:bg-blue-50"
                    onClick={() => {/* Implement video play functionality */}}
                  >
                    <Play className="mr-2 h-4 w-4" />
                    Watch Guide
                  </Button>
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

        {/* Fun Facts Carousel */}
        <div className="mt-16 bg-gradient-to-r from-blue-100 to-purple-100 rounded-xl p-8">
          <h3 className="text-2xl font-bold mb-6 text-center">Window Sticker Fun Facts</h3>
          <div className="relative">
            <div className="overflow-hidden">
              <div className="flex transition-transform duration-500 ease-in-out transform -translate-x-full">
                {[
                  "Window stickers became mandatory in the US in 1958.",
                  "They're named after Senator Mike Monroney, who championed the Automobile Information Disclosure Act.",
                  "The fuel economy section was added in 2008 to promote environmental awareness.",
                  "QR codes on modern window stickers can provide even more detailed vehicle information."
                ].map((fact, index) => (
                  <div key={index} className="flex-shrink-0 w-full px-4">
                    <p className="text-center text-gray-700">{fact}</p>
                  </div>
                ))}
              </div>
            </div>
            <Button variant="ghost" className="absolute top-1/2 left-0 transform -translate-y-1/2" onClick={() => {/* Implement previous slide */}}>
              <ChevronLeft className="h-6 w-6" />
            </Button>
            <Button variant="ghost" className="absolute top-1/2 right-0 transform -translate-y-1/2" onClick={() => {/* Implement next slide */}}>
              <ChevronRight className="h-6 w-6" />
            </Button>
          </div>
        </div>

        {/* Benefits Statistics Section */}
        <section className="py-16 bg-white">
          <div className="container mx-auto px-4">
            <h2 className="text-3xl font-bold text-center mb-12 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
              Window Stickers: Your Key to Smarter Car Buying
            </h2>

            <div className="grid gap-8 md:grid-cols-3 mb-16">
              {[
                {
                  percentage: "43%",
                  source: "J.D. Power",
                  text: "of online car shoppers rely on window stickers"
                },
                {
                  percentage: "61%",
                  source: "AutoTrader",
                  text: "more likely to contact dealers with sticker info"
                },
                {
                  percentage: "25%",
                  source: "Cox Automotive",
                  text: "boost in lead conversion with window stickers"
                }
              ].map((stat, index) => (
                <div 
                  key={index}
                  className="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-50 to-white p-8 shadow-lg hover:shadow-xl transition-all duration-300"
                >
                  <div className="absolute top-0 left-0 w-2 h-full bg-blue-600 transform -skew-x-12"></div>
                  <div className="relative">
                    <div className="text-4xl font-bold text-blue-600 mb-2 group-hover:scale-110 transition-transform duration-300">
                      {stat.percentage}
                    </div>
                    <div className="text-sm text-gray-600 mb-2">Source: {stat.source}</div>
                    <p className="text-gray-800 font-medium">{stat.text}</p>
                  </div>
                </div>
              ))}
            </div>

            <h3 className="text-2xl font-bold text-center mb-8">
              Empowering Every Step of the Car Journey
            </h3>

            <div className="grid gap-6 max-w-4xl mx-auto">
              {[
                {
                  title: "Buyers: Drive Informed",
                  icon: "🚗",
                  benefits: [
                    "Spot the best deals with easy comparisons",
                    "Avoid scams with verified vehicle info",
                    "Make confident decisions with complete feature lists",
                    "Compare efficiency and safety at a glance",
                    "Negotiate like a pro with pricing insights"
                  ]
                },
                {
                  title: "Sellers: Showcase with Confidence",
                  icon: "🤝",
                  benefits: [
                    "Highlight your car's best features effortlessly",
                    "Justify your price with transparent specs",
                    "Build trust through comprehensive information"
                  ]
                },
                {
                  title: "Dealerships: Elevate Your Business",
                  icon: "🏢",
                  benefits: [
                    "Stay compliant with regulations effortlessly",
                    "Stand out in a crowded market",
                    "Boost customer loyalty with transparency",
                    "Streamline operations with accurate info"
                  ]
                }
              ].map((category, index) => (
                <div
                  key={index}
                  className="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden"
                >
                  <div className="p-6 cursor-pointer">
                    <div className="flex items-center gap-4 mb-4">
                      <span className="text-3xl">{category.icon}</span>
                      <h4 className="text-xl font-semibold group-hover:text-blue-600 transition-colors">
                        {category.title}
                      </h4>
                    </div>
                    <ul className="space-y-3">
                      {category.benefits.map((benefit, i) => (
                        <li key={i} className="flex items-start gap-2">
                          <div className="mt-1.5 h-2 w-2 rounded-full bg-blue-600 shrink-0"></div>
                          <span className="text-gray-600">{benefit}</span>
                        </li>
                      ))}
                    </ul>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Classic Car Build Sheet Section */}
        <section className="py-12 bg-gradient-to-br from-white to-gray-50">
          <div className="container mx-auto px-4">
            <div className="flex flex-col md:flex-row items-center justify-between gap-8">
              <div className="md:w-1/2 text-center md:text-left">
                <h2 className="text-3xl font-bold mb-4">
                  Classic Car Build Sheets
                </h2>
                <p className="text-lg text-gray-600 mb-6">
                  Unlock your classic car's heritage with authentic build sheets. Verify specs and features for restoration or collection.
                </p>
                <Button 
                  className="bg-blue-600 hover:bg-blue-700 text-white"
                  size="lg"
                >
                  View Sample Build Sheet
                </Button>
              </div>
              <div className="md:w-1/2 relative group">
                <Image
                  src="/placeholder.svg"
                  alt="Classic Car Build Sheet"
                  width={500}
                  height={300}
                  className="rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-[1.02]"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl" />
                <div className="absolute bottom-4 left-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  <p className="text-sm font-semibold">1966 Ford Mustang Series</p>
                  <p className="text-xs">Original Base Price: $2,653 | Production: 72,119 units</p>
                </div>
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
        <section className="py-12 bg-white">
          <div className="container mx-auto px-4">
            <h2 className="text-2xl font-bold text-center mb-6">
              Window Stickers Lookup By VIN for All Manufacturers
            </h2>

            <div className="mb-6">
              <div className="flex flex-wrap justify-center gap-2">
                {['A-C', 'D-F', 'G-I', 'J-L', 'M-O', 'P-R', 'S-U', 'V-Z'].map((group) => (
                  <Button
                    key={group}
                    variant="outline"
                    className="px-3 py-1 font-semibold hover:bg-blue-50 hover:text-blue-600 data-[state=active]:bg-blue-100 data-[state=active]:text-blue-600"
                    data-state={['A-C', 'G-I', 'M-O', 'S-U'].includes(group) ? 'active' : 'inactive'}
                  >
                    {group}
                  </Button>
                ))}
              </div>
            </div>

            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              {[
                { group: 'A-C', brands: ['Acura', 'BMW', 'Chevrolet', 'Chrysler'] },
                { group: 'D-F', brands: ['Dodge', 'Ford', 'Ferrari'] },
                { group: 'G-I', brands: ['GMC', 'Honda', 'Infiniti'] },
                { group: 'J-L', brands: ['Jeep', 'Kia', 'Lexus'] },
                { group: 'M-O', brands: ['Mazda', 'Mercedes-Benz', 'Nissan'] },
                { group: 'P-R', brands: ['Porsche', 'Ram', 'Rolls-Royce'] },
                { group: 'S-U', brands: ['Subaru', 'Tesla', 'Toyota'] },
                { group: 'V-Z', brands: ['Volkswagen', 'Volvo'] }
              ].map((group) => (
                <div key={group.group} className="space-y-2">
                  <h3 className="text-lg font-bold text-blue-600">{group.group}</h3>
                  {group.brands.map((brand) => (
                    <Button
                      key={brand}
                      variant="ghost"
                      className="w-full justify-start px-2 py-1 h-auto text-sm font-normal hover:bg-blue-50 hover:text-blue-600"
                    >
                      {brand}
                    </Button>
                  ))}
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Dealer Solutions Section */}
        <section className="py-16 bg-white">
          <div className="container mx-auto px-4">
            <h2 className="text-4xl font-bold text-center mb-8">
              Professional Window Sticker Solutions for Dealerships
            </h2>
            <div className="max-w-3xl mx-auto text-center mb-12">
              <p className="text-lg text-gray-600 mb-6">
                Enhance your dealership's professional image while ensuring compliance with our comprehensive window sticker solutions. Our customizable options help boost sales and streamline trade-in evaluations.
              </p>
              <p className="text-lg text-gray-600">
                We've developed flexible window sticker solutions that cater to the unique needs of automotive dealerships, offering both standardized and custom options to match your specific business requirements.
              </p>
            </div>
            <div className="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
              <div className="bg-gradient-to-br from-blue-50 to-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h3 className="text-2xl font-bold text-blue-600 mb-4">Standard Edition</h3>
                <p className="text-gray-600 mb-6">
                  Elevate your dealership with our professional branded window stickers. Featuring your dealership's identity alongside comprehensive vehicle details, our solution helps increase ROI and streamline sales processes with our intuitive window sticker platform.
                </p>
                <Button className="bg-blue-600 hover:bg-blue-700 text-white">
                  Explore Standard Options
                </Button>
              </div>
              <div className="bg-gradient-to-br from-purple-50 to-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h3 className="text-2xl font-bold text-purple-600 mb-4">Custom Edition</h3>
                <p className="text-gray-600 mb-6">
                  Create fully personalized window stickers that perfectly match your brand. Incorporate your logo, business information, operating hours, location details, and more to transform every window sticker into a powerful marketing asset.
                </p>
                <Button className="bg-purple-600 hover:bg-purple-700 text-white">
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

        {/* CTA Section */}
        <div className="text-center bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl p-8 text-white mt-16">
          <h2 className="text-2xl font-semibold mb-4">
            Ready to Unlock Your Vehicle's Full Story?
          </h2>
          <p className="mb-6 text-blue-50">
            Get your original window sticker now and take control of your car's narrative
          </p>
          <Button size="lg" variant="secondary" className="hover:bg-white transition-all duration-300">
            Get Your Window Sticker
          </Button>
        </div>
      </div>
    </div>
  )
}

