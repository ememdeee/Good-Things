'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Search, Shield, Clock, FileText, AlertTriangle, Car, FileCheck, Link, ShieldAlert, Gauge, ClipboardCheck, Bell } from 'lucide-react'
import Image from 'next/image'
import { CTASection } from './CTASection'
import SiteForm from './SiteForm'

const lookupItems = [
  { title: "Vehicle Specifications", icon: Car },
  { title: "Ownership History", icon: FileText },
  { title: "Accident Reports", icon: AlertTriangle },
  { title: "Title Information", icon: FileCheck },
  { title: "Lien Records", icon: Link },
  { title: "Theft Records", icon: ShieldAlert },
  { title: "Odometer Readings", icon: Gauge },
  { title: "Registration Status", icon: ClipboardCheck },
  { title: "Recall Information", icon: Bell },
]

export function LicensePlateLookupContent() {
  const [state, setState] = useState('')

  return (
    <div className="min-h-screen">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            License Plate Lookup
          </Badge>
          <h1 className="text-4xl font-bold mb-4">
            Instant Vehicle History by License Plate
          </h1>
          <p className="text-lg text-gray-600">
            Get comprehensive vehicle information using just the license plate number. Fast, accurate, and secure.
          </p>
        </div>

        {/* Search Section */}
        <div className="max-w-2xl mx-auto mb-12">
          <SiteForm />
        </div>

        <div className="grid md:grid-cols-2 gap-12 items-center mb-16">
          <div className="space-y-6">
            <h2 className="text-3xl font-bold">Why Use License Plate Lookup?</h2>
            <ul className="space-y-4">
              {[
                { icon: Shield, text: "Verify vehicle ownership and registration details" },
                { icon: Clock, text: "Access real-time, up-to-date vehicle information" },
                { icon: FileText, text: "Get comprehensive vehicle history reports" },
                { icon: AlertTriangle, text: "Identify potential issues or red flags" },
              ].map((item, index) => (
                <li key={index} className="flex items-center space-x-3">
                  <item.icon className="w-6 h-6 text-blue-600" />
                  <span>{item.text}</span>
                </li>
              ))}
            </ul>
            <Button variant="outline">Learn More About Our Services</Button>
          </div>
          <div className="relative">
            <Image
              src="/License Plate Lookup Hero Section.png"
              alt="License Plate Lookup Illustration"
              width={500}
              height={500}
            />
          </div>
        </div>

        <div className="">
          <h2 className="text-3xl font-bold mb-8 text-center">
            What&apos;s Included in Our License Plate Lookup?
          </h2>
          <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {lookupItems.map((item, index) => (
              <Card key={index} className="transition-all duration-300 hover:shadow-md hover:scale-105">
                <CardContent className="flex items-center space-x-4 p-6">
                  <div className="bg-gray-50 p-3 rounded-full">
                    <item.icon className="w-6 h-6 " />
                  </div>
                  <span className="font-medium text-gray-700">{item.title}</span>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>

        <CTASection
          title="Ready to Get Started?"
          description="Our license plate lookup service provides you with instant, accurate information about any vehicle. Try it now!"
          buttonText="Start Your Search"
          buttonLink="/get-window-sticker"
        />
      </div>
    </div>
  )
}

