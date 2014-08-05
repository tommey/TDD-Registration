#!/bin/bash

# Code climate report generator and sender - hack over SSL cert problem.

REPORT_FILE="build/logs/codeclimate.json"

# Run report generator.
bash $(dirname $0)/../vendor/bin/test-reporter --stdout > ${REPORT_FILE}

# Send report to code climate.
curl -X POST -d @${REPORT_FILE} -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.2)' https://codeclimate.com/test_reports
