#!/bin/sh

# Code climate report generator and sender - hack over SSL cert problem.

# Run report generator.
./vendor/bin/test-reporter --stdout > build/log/codeclimate.json

# Send report to code climate.
curl -X POST -d @build/log/codeclimate.json -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.2)' https://codeclimate.com/test_reports
