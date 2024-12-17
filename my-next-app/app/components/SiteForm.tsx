'use client';

import React, { useState } from 'react';
import { Card, CardContent } from '@/components/ui/card';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import Link from 'next/link';

interface SiteFormProps {
    reportType?: 'VHR' | 'WS'; // Define the allowed reportType values
}

const SiteForm: React.FC<SiteFormProps> = ({ reportType = 'VHR' }) => {
  const [activeTab, setActiveTab] = useState<string>('vin');
  const [isLoading, setIsLoading] = useState<boolean>(false); // Add loading state
  const [vin, setVin] = useState<string>('');
  const [plate, setPlate] = useState<string>('');
  const [state, setState] = useState<string>('');
  const [email, setEmail] = useState<string>('');
  const [phone, setPhone] = useState<string>('');
  const [errors, setErrors] = useState<Record<string, string>>({});

  const states = [
    { code: 'CA', name: 'California' },
    { code: 'TX', name: 'Texas' },
    { code: 'NY', name: 'New York' },
    { code: 'VA', name: 'Virginia' },
    { code: 'FL', name: 'Florida' },
  ];
  

  // Input validation and formatting
  const handleVinChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const uppercasedValue = e.target.value.toUpperCase();
    setVin(uppercasedValue.slice(0, 17)); // Max length: 17
  };

  const handlePlateChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const uppercasedValue = e.target.value.toUpperCase();
    setPlate(uppercasedValue.slice(0, 8)); // Max length: 8
  };

  const handlePhoneChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const numericValue = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
    setPhone(numericValue.slice(0, 15)); // Max length: 15
  };

  const validateForm = () => {
    const newErrors: Record<string, string> = {};

    if (activeTab === 'vin') {
      if (!vin || vin.length < 5 || vin.length > 17) {
        newErrors.vin = 'VIN must be between 5 and 17 characters.';
      }
    } else if (activeTab === 'plate') {
      if (!plate || plate.length < 5 || plate.length > 8) {
        newErrors.plate = 'License Plate must be between 5 and 8 characters.';
      }
      if (!state) {
        newErrors.state = 'State is required.';
      }
    }

    if (!email) {
        newErrors.email = 'Email is required.';
    } else if (!/\S+@\S+\.\S+/.test(email)) {
    newErrors.email = 'Please enter a valid email address.';
    }
      

    if (phone && (phone.length < 8 || phone.length > 15)) {
      newErrors.phone = 'Phone number must be between 8 and 15 digits.';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

    // Fetch license plate to VIN function
    const fetchVinData = async (stateInputValue: string, plateInputValue: string): Promise<string> => {
        try {
          const requestData = {
            state: stateInputValue,
            plate: plateInputValue,
            email: 'test@test.com', // Static email
          };
      
          const apiUrl = 'https://app.detailedvehiclehistory.com/landing/get_license';
      
          const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded', // Match the jQuery behavior
            },
            body: new URLSearchParams(requestData), // Use URLSearchParams for form data
          });
      
          // Log the raw response for debugging
          const rawResponse = await response.text();
          console.log('Raw API Response:', rawResponse);
      
          // Parse response manually
          const responseData = JSON.parse(rawResponse);
          console.log('Parsed Response Data:', responseData);
      
          const { vin } = responseData;
      
          if (!vin) {
            throw new Error('VIN not found in the response');
          }
      
          return vin;
        } catch (error) {
          console.error('Failed to fetch VIN:', error);
          throw error;
        }
      };

    const handleSubmit = async () => {
    if (validateForm()) {
      setIsLoading(true);
      if (activeTab === 'vin') {
        console.log('Submitted Data:', { vin, email, phone });
        
        // Redirect with VIN data
        const redirectUrl = reportType === 'WS'
          ? `https://detailedvehiclehistory.com/vin-check/ws-preview?vin=${vin}&email=${email}&mobile=${phone}&ref=testing-site`
          : `https://detailedvehiclehistory.com/vin-check/preview?vin=${vin}&email=${email}&mobile=${phone}&ref=testing-site`;

        window.location.href = redirectUrl;
      } else if (activeTab === 'plate') {
        console.log('Submitted Data:', { plate, state, email, phone });

        try {
            // Fetch the VIN based on state and license plate
            const fetchedVin = await fetchVinData(state, plate);
    
            console.log('Fetched VIN:', fetchedVin);
    
            // Redirect with fetched VIN data
            const redirectUrl = reportType === 'WS'
            ? `https://detailedvehiclehistory.com/vin-check/ws-preview?vin=${fetchedVin}&email=${email}&mobile=${phone}&ref=testing-site`
            : `https://detailedvehiclehistory.com/vin-check/preview?vin=${fetchedVin}&email=${email}&mobile=${phone}&ref=testing-site`;
            
            window.location.href = redirectUrl;
            } catch (error) {
              alert('Error fetching VIN. Please try again.');
            } finally {
              setIsLoading(false); // Reset loading state
            }
        }
    }
  };

  return (
    <Card className="bg-transparent">
      <CardContent className="p-6">
        {/* Tabs Section */}
        <Tabs defaultValue="vin" className="w-full" onValueChange={(val) => { setActiveTab(val); setErrors({}); }}>
          <TabsList className="grid w-full grid-cols-2 mb-6">
            <TabsTrigger value="vin">By VIN</TabsTrigger>
            <TabsTrigger value="plate">By US License Plate</TabsTrigger>
          </TabsList>

          {/* Content Section */}
          <div className="space-y-4">
            {activeTab === 'vin' && (
              <div>
                <Input
                  placeholder="Enter VIN Number"
                  className="text-sm"
                  value={vin}
                  onChange={handleVinChange}
                />
                {errors.vin && <p className="text-red-500 text-sm">{errors.vin}</p>}
              </div>
            )}

            {activeTab === 'plate' && (
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Input
                    placeholder="License Plate"
                    className="text-sm"
                    value={plate}
                    onChange={handlePlateChange}
                  />
                  {errors.plate && <p className="text-red-500 text-sm">{errors.plate}</p>}
                </div>
                <div>
                  <select
                    className="text-sm border rounded-md p-2 w-full bg-transparent"
                    value={state}
                    onChange={(e) => setState(e.target.value)}
                  >
                    <option value="">Select State</option>
                    {states.map((state, index) => (
                        <option key={index} value={state.code}>
                        {state.name}
                        </option>
                    ))}
                  </select>
                  {errors.state && <p className="text-red-500 text-sm">{errors.state}</p>}
                </div>
              </div>
            )}

            {/* Email and Phone Section */}
            <div className="grid grid-cols-2 gap-4">
              <div>
                <Input
                  type="email"
                  placeholder="Email Address"
                  value={email}
                  className="text-sm"
                  onChange={(e) => setEmail(e.target.value)}
                />
                {errors.email && <p className="text-red-500 text-sm">{errors.email}</p>}
              </div>
              <div>
                <Input
                  type="tel"
                  placeholder="Phone (Optional)"
                  value={phone}
                  className="text-sm"
                  onChange={handlePhoneChange}
                />
                {errors.phone && <p className="text-red-500 text-sm">{errors.phone}</p>}
              </div>
            </div>

            {/* Search Button */}
            <Button className="w-full" onClick={handleSubmit} disabled={isLoading}>
              {isLoading ? 'Please wait...' : 'Search'}
            </Button>


            {/* Links Section */}
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
  );
};

export default SiteForm;