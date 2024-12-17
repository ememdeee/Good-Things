'use client'

import { useState } from 'react'
import Image from 'next/image'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs'

export function Hero() {
  const [searchType, setSearchType] = useState('vin')

  return (
    <section className="relative overflow-hidden bg-gray-50 py-12 md:py-20">
      <div className="container mx-auto px-4">
        <div className="grid gap-12 lg:grid-cols-2 lg:gap-8">
          <div className="flex flex-col justify-center space-y-8">
            <div className="space-y-4">
              <h1 className="text-4xl font-bold tracking-tighter sm:text-5xl">
                Maximize Your Car's Value with Complete History & Original Window Sticker
              </h1>
              <p className="text-xl text-gray-600">
                Get instant access to your vehicle's complete history and authentic window sticker. 
                Perfect for sellers looking to build trust and get top dollar.
              </p>
            </div>
            <div className="space-y-4">
              <Tabs defaultValue="vin" className="w-full" onValueChange={setSearchType}>
                <TabsList className="grid w-full max-w-[400px] grid-cols-2">
                  <TabsTrigger value="vin">by VIN</TabsTrigger>
                  <TabsTrigger value="plate">by US License Plate</TabsTrigger>
                </TabsList>
              </Tabs>
              <div className="flex max-w-[600px] space-x-2">
                <Input 
                  placeholder={searchType === 'vin' ? "Enter VIN Number" : "Enter License Plate"} 
                  className="flex-1"
                />
                <Button size="lg" className="px-8">
                  Check Now
                </Button>
              </div>
              <p className="text-sm text-gray-500">
                No VIN? <a href="#" className="text-blue-600 hover:underline">Find it here</a>
              </p>
            </div>
          </div>
          <div className="relative lg:pl-8">
            <div className="relative mx-auto max-w-[350px]">
              <Image
                src="/placeholder.svg"
                alt="Vehicle History Report Preview"
                width={350}
                height={700}
                className="rounded-3xl shadow-2xl"
              />
              <Image
                src="/placeholder.svg"
                alt="Luxury Car"
                width={500}
                height={300}
                className="absolute -right-24 -bottom-12 w-[200%] max-w-none rounded-lg shadow-xl lg:-right-48"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

